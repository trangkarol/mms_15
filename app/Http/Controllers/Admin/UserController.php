<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use \Illuminate\Pagination\Paginator;
use App\Http\Requests\User\InsertUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Requests\User\AddPositionRequest;
use App\Http\Requests\User\AddSkillRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ReportController as Report;
use App\Helpers\Library;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\Position;
use App\Models\PositionTeam;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\Skill;
use App\Models\SkillUser;
use App\Models\Activity;
use Carbon\Carbon;
use App\Mail\SendPassword;
use Mail;
use DB;
use DateTime;

class UserController extends Controller
{
    protected $user;
    protected $activity;
    protected $library;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        Activity $activity,
        Library $library,
        TeamUser $teamUser
    ) {
        $this->user = $user;
        $this->activity = $activity;
        $this->library = $library;
        $this->teamUser = $teamUser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = $this->library->getLibraryTeams();
        $position = $this->library->getPositions();
        $positionTeams = $this->library->getPositionTeams();
        $members  = $this->user->with('position', 'teamUsers', 'teamUsers.positions', 'teamUsers.team')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.user.index', compact('members', 'teams', 'position', 'positionTeams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = $this->library->getPositions();

        return view('admin.user.create', compact('positions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $input = $request->only(['name', 'email', 'birthday', 'role']);
            $password = str_random(8);
            $input['password'] = $password;
            //images
            $input['avatar'] = $this->library->importFile($request->file);
            $input['position_id'] = $request->position;
            $user = $this->user->create($input);
            $this->activity->insertActivities($user, 'insert');
            $request->session()->flash('success', trans('user.msg.insert-success'));
            // send password to user
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ];

            Mail::to($request->email)->queue(new SendPassword($data));
            DB::commit();

            return redirect()->action('Admin\UserController@edit', $user->id);
        } catch (\Exception $e) {
            $request->session()->flash('fail', trans('user.msg.insert-fail'));
            DB::rollback();

            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $levels = $this->library->getLevel();
        $positions = $this->library->getPositions();
        $skills = $this->library->getLibrarySkills();
        $skillUsers = SkillUser::skillUsers($id)->get();
        $skillId = $skillUsers->pluck('skill_id')->all();
        // team
        $teams = $this->library->getLibraryTeams();
        $teamUser = $this->teamUser->where('user_id', $id)->get();
        $arrTeam = $this->teamUser->where('user_id', $id)->pluck('team_id')->all();
        $teamUserId = $this->teamUser->where('user_id', $id)->pluck('id')->all();
        $positionTeams = $this->teamUser->with('team', 'positions')->whereIn('id', $teamUserId)->get();

        return view('admin.user.edit', compact('user', 'positions', 'levels', 'skills', 'skillUsers', 'skillId', 'teams', 'arrTeam', 'positionTeams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->user->find($request->userId);
            $input = $request->only('name', 'email', 'birthday', 'role');
            $input['id'] = $user->id;
            if (isset($request->file)) {
                $this->library->deleteFile($user->avatar);
                $input['avatar'] = $this->library->importFile($request->file);
            }

            $user->position()->associate($request->position);
            $user->update($input);
            $this->activity->insertActivities($user, 'update');
            $request->session()->flash('success', trans('user.msg.update-success'));
            DB::commit();

            return redirect()->action('Admin\UserController@edit', $user->id);
        } catch (\Exception $e) {
            $request->session()->flash('fail', trans('user.msg.update-fail'));
            DB::rollback();

            return redirect()->action('Admin\UserController@edit', $user->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $userId = $request->userId;
        DB::beginTransaction();
        try {
            $user = $this->user->findOrFail($userId);
            $teamUsers = $this->teamUser->getUser($userId);
            $teamUserId = $teamUsers->pluck('id')->all();
            $project = ProjectTeam::getId($teamUserId)->delete();
            $position = PositionTeam::getId($teamUserId)->delete();
            $teamUsers->delete();
            $user->delete();
            $this->activity->insertActivities($user, 'delete');
            $request->session()->flash('success', trans('user.msg.delete-success'));
            DB::commit();

            return redirect()->action('Admin\UserController@index');
        } catch (\Exception $e) {
            $request->session()->flash('fail', trans('user.msg.delete-fail'));
            DB::rollback();

            return redirect()->back();
        }
    }

    /**
     * search user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $input = $request->only('teamId', 'position', 'positionTeams');
        try {
            $user = $this->getMember($input['teamId'], $input['position'], $input['positionTeams']);
            $members  = $user->orderBy('created_at', 'desc')->paginate(15);
            $html = view('admin.user.table_result', compact('members'))->render();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (\Exception $e) {
            return response()->json('false', false);
        }
    }

    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function addSkill(AddSkillRequest $request)
    {
        $input = $request->only('userId', 'skillId', 'exeper', 'level', 'flag');
        DB::beginTransaction();
        try {
            if (!$flag) {//update user skill
                $userSkill = SkillUser::where('skill_id', $input['skillId'])->where('user_id', $input['userId'])->delete();
            }

            $userSkill = $this->user->find($input['userId']);
            $userSkill->skills()->attach([$input['skillId']=>[
                'experiensive' => $input['exeper'],
                'level' => $input['level']
                ]]);

            $skillUsers = SkillUser::skillUsers($input['userId'])->get();
            $levels = $this->library->getLevel();
            $html = view('admin.user.list_skill', compact('skillUsers', 'levels'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html, 'flag' => $input['flag']]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteSkill(Request $request)
    {
        $skillId = $request->skillId;
        $userId = $request->userId;
        DB::beginTransaction();
        try {
            $userSkill = SkillUser::where('skill_id', $skillId)->where('user_id', $userId)->delete();
            $skillUsers = SkillUser::skillUsers($userId)->get();
            $levels = $this->library->getLevel();
            $html = view('admin.user.list_skill', compact('skillUsers', 'levels'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }


    /**
     * positionTeam
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function positionTeam(PositionRequest $request)
    {
        $userId = $request->userId;
        $teamId = $request->teamId;
        $flag = $request->flag;
        DB::beginTransaction();
        try {
            $arrPosition = [];
            if ($flag == config('setting.update') || $flag == config('setting.delete')) {
                $teamUserId = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->pluck('id')->first();
                // positions
                $positionIds = PositionTeam::with('positions')->where('team_user_id', $teamUserId)->pluck('position_id')->all();
            }

            $positions = $this->librarygetPositionTeams();
            $html = view('admin.user.position_team', compact('positions', 'userId', 'teamId', 'flag', 'positionIds'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function addTeam(AddTeamRequest $request)
    {
        $userId = $request->userId;
        $teamId = $request->teamId;
        $positions = $request->positions;
        $flag = $request->flag;
        DB::beginTransaction();
        try {
            if ($flag) {
                $team = $this->user->find($userId)->teams()->attach($teamId);
            }

            $teamUserId = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->pluck('id')->first();
            $teamUser = TeamUser::find($teamUserId)->positions()->sync($positions);
            DB::commit();
            $teamUserIds = TeamUser::where('user_id', $userId)->pluck('id')->all();
            $positionTeams = TeamUser::with('team', 'positions')->whereIn('id', $teamUserIds)->get();
            $html = view('admin.user.team', compact('positionTeams'))->render();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * delete Team
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteTeam(DeleteTeamRequest $request)
    {
        $teamId = $request->teamId;
        $userId = $request->userId;
        DB::beginTransaction();
        try {
            $teamUserId = TeamUser::getTeam($teamId)->getUser($userId)->pluck('id')->first();
            PositionTeam::whereIn('team_user_id', $teamUser)->delete();
            $projectId = ProjectTeam::where('team_user_id', $teamUserId)->pluck('project_id')->all();
            if (!empty($projectId)) {
                $teamUser = TeamUser::find($teamUserId)->projects()->detach($projectId);
            }

            //delete team user
            $team = $this->user->find($userId)->teams()->detach($teamId);
            $teamUserId = $this->teamUser->getUser($userId)->pluck('id')->all();
            $positionTeams = $this->teamUser->with('team', 'positions')->teamUserId($teamUserId)->get();
            $html = view('admin.user.team', compact('positionTeams'))->render();
            DB::commit();

            return response()->json([ 'result' => true, 'html' => $html ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * get skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function getSkill(Request $request)
    {
        $input = $request->only('userId', 'skillId', 'flag');
        DB::beginTransaction();
        try {
            $arrPosition = [];

            if ($flag != config('setting.insert')) {
                $userSkill = SkillUser::with('skill')->where('skill_id', $skillId)->where('user_id', $userId)->first();
            }

            $skills = $this->library->getLibrarySkills();
            $levels = $this->library->getLevel();
            $html = view('admin.user.skill', compact('skills', 'levels', 'flag', 'userId', 'skillId', 'userSkill'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * import File
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function importFile(ImportFileRequest $request)
    {
        $file = $request->file;
        try {
            $nameFile = '';

            if (isset($file)) {
                $nameFile = $this->library->importFile($file);
                $members = Report::importFileExcel($nameFile);
                $position = $this->library->getPositions();
            }

            return view('admin.user.table_scv', compact('members', 'position', 'nameFile'));
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * export File
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function exportFile(ExportFileRequest $request)
    {
        $input = $request->only('type', 'teamId', 'position', 'positionTeams');
        try {
            $dt = new DateTime();
            $user = $this->getMember($input);
            $members = $user->get();
            $nameFile = 'user_' . $dt->format('Y-m-d-H-i-s');
            Report::exportFileExcel($members, $$input['type'], $nameFile);
            unlink(config('setting.url_upload') . $nameFile);
            $request->session()->flash('success', trans('user.msg.import-success'));

            return redirect()->action('Admin\UserController@index');
        } catch (\Exception $e) {
            return response()->json('result', false);
        }
    }

    /**
     * save Import
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function saveImport(SaveImportRequest $request)
    {
        $nameFile = $request->nameFile;
        DB::beginTransaction();
        try {
            $members = Report::importFileExcel($nameFile)->toArray();
            foreach ($members as $user) {
                $insert = $this->dataMember($user);
                //insert password
                $password = str_random(config('setting.number_password'));
                $insert['password'] = $password;

                if (!$this->validator($insert)->validate()) {
                    Mail::to($insert['email'])->queue(new SendPassword($insert));
                    $insert['password'] = bcrypt($password);
                    $user = $this->user->create($insert);
                    $this->activity->insertActivities($user, 'insert');
                }
            }

            $request->session()->flash('success', trans('user.msg.import-success'));
            DB::commit();

            return redirect()->action('Admin\UserController@index');
        } catch (\Exception $e) {
            $request->session()->flash('fail', trans('user.msg.import-fail'));
            DB::rollback();

            return redirect()->action('Admin\UserController@index');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'position_id' => 'required',
            'password' => 'required',
            'birthday' => 'required',
        ]);
    }

    /**
     *data Member.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function dataMember($member)
    {
        $data = [];
        $data['name'] = $member['name'];
        $data['email'] = $member['email'];
        $data['role']= $member['role'];
        $data['avatar']= config('setting.avatar');
        $data['birthday'] = $member['birthday'];
        $data['position_id'] = $member['position'];
        return $data;
    }

    /**
     *get Member.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function getMember($teamId, $position, $positionTeams)
    {
        $user = $this->user;
        // team
        if ($teamId != config('setting.search_all')) {
            $user = $user->whereHas('teamUsers.team', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            });
        } else {
            $user = $user->with('teamUsers.team');
        }

        // position
        if ($position != config('setting.search_all')) {
            $user = $user->with('position')->where('position_id', $position);
        } else {
            $user = $user->with('position');
        }

        //positionTeams
        if ($positionTeams != config('setting.search_all')) {
            $user = $user->whereHas('teamUsers.positions', function ($query) use ($positionTeams) {
                $query->where('position_id', $positionTeams);
            });
        } else {
            $user = $user->with('teamUsers.positions');
        }

        return $user;
    }
}
