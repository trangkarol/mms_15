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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        User $user,
        Activity $activity,
        Library $library
    ) {
        $this->user = $user;
        $this->activity = $activity;
        $this->library = $library;
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
        $members  = $this->user->with('position', 'teamUsers', 'teamUsers.positions', 'teamUsers.team')
                    ->orderBy('created_at', 'desc')->paginate(15);

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
        $teamUser = TeamUser::where('user_id', $id)->get();
        $arrTeam = TeamUser::where('user_id', $id)->pluck('team_id')->all();
        $teamUserId = TeamUser::where('user_id', $id)->pluck('id')->all();
        $positionTeams = TeamUser::with('team', 'positions')->whereIn('id', $teamUserId)->get();

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
                if ($user->avatar != "avatar.jpg" && !is_null($user->avatar)) {
                    $urlAvartar = base_path() . '/public/Upload/' . $user->avatar;
                    unlink($urlAvartar);
                }

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
        DB::beginTransaction();

        try {
            $userId = $request->userId;
            $user = $this->user->findOrFail($userId);
            $teamUsers = TeamUser::getUser($userId);
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
        try {
            $teamId = $request->teamId;
            $position = $request->position;
            $positionTeams = $request->positionTeams;
            $user = $this->getMember($teamId, $position, $positionTeams);
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
        $userId = $request->userId;
        $skill = $request->skillId;
        $exeper = $request->exeper;
        $level = $request->level;
        $flag = $request->flag;
        DB::beginTransaction();
        try {
            if ($flag == 0) {//update user skill
                $userSkill = SkillUser::where('skill_id', $skill)->where('user_id', $userId)->delete();
            }
            $userSkill = $this->user->find($userId);
            $userSkill->skills()->attach([$skill=>[
                'experiensive' => $exeper,
                'level' => $level
                ]]);

            $skillUsers = SkillUser::skillUsers($userId)->get();
            $levels = $this->library->getLevel();
            $html = view('admin.user.list_skill', compact('skillUsers', 'levels'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html, 'flag' => $flag]);
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
    public function positionTeam(Request $request)
    {
        $userId = $request->userId;
        $teamId = $request->teamId;
        $flag = $request->flag;
        DB::beginTransaction();
        try {
            $arrPosition = [];
            if ($flag == 0 || $flag == 2) {
                $teamUserId = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->pluck('id');
                // positions
                $arrPosition = PositionTeam::with('positions')->where('team_user_id', $teamUserId[0])->pluck('position_id')->all();
            }
            $positions = $this->library->getPositionTeams();
            $html = view('admin.user.position_team', compact('positions', 'userId', 'teamId', 'flag', 'arrPosition'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    /**
     * add team
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function addTeam(AddPositionRequest $request)
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

            $teamUserId = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->pluck('id')->all();
            $teamUser = TeamUser::find($teamUserId[0])->positions()->sync($positions);
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
     * delete team
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteTeam(Request $request)
    {
        $teamId = $request->teamId;
        $userId = $request->userId;
        DB::beginTransaction();
        try {
            $teamUser = TeamUser::getTeam($teamId)->getUser($userId)->pluck('id')->all();
            // delete position team
            PositionTeam::whereIn('team_user_id', $teamUser)->delete();
            // delete project team
            $projectId = ProjectTeam::where('team_user_id', $teamUser[0])->pluck('project_id')->all();
            if (!empty($projectId)) {
                $teamUser = TeamUser::find($teamUser[0])->projects()->detach($projectId);
            }

            //delete team user
            $team = $this->user->find($userId)->teams()->detach($teamId);
            $teamUserId = TeamUser::getUser($userId)->pluck('id')->all();
            $positionTeams = TeamUser::with('team', 'positions')->teamUserId($teamUserId)->get();
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
        $userId = $request->userId;
        $skillId = $request->skillId;
        $flag = $request->flag;
        DB::beginTransaction();
        try {
            $arrPosition = [];
            if ($flag == 0 || $flag == 2) {
                $userSkill = SkillUser::with('skill')->where('skill_id', $skillId)->where('user_id', $userId)->first();
            }

            $skills = $this->library->getLibrarySkills();
            $levels = $this->library->getLevel();
            $html = view('admin.user.skill', compact('skills', 'levels', 'flag', 'userId', 'skillId', 'userSkill'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    public function importFile(Request $request)
    {
        $file = $request->file;
        try {
            $report = new Report;
            $nameFile = '';
            if (isset($file)) {
                $nameFile = $this->library->importFile($file);
                $members = Report::importFileExcel($nameFile);
                $position = $this->library->getPositions();
            }

            return view('admin.user.table_scv', compact('members', 'position', 'nameFile'));
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json('result', false);
        }
    }

    public function exportFile(Request $request)
    {
        $type = $request->type;
        $teamId = $request->teamId;
        $position = $request->position;
        $positionTeams = $request->positionTeams;
        try {
            $dt = new DateTime();
            $user = $this->getMember($teamId, $position, $positionTeams);
            $members = $user->get();
            $nameFile = 'user'.$dt->format('Y-m-d-H-i-s');
            Report::exportFileExcel($members, $type, $nameFile);
                unlink(base_path() . '/public/Upload/' . $nameFile);
            $request->session()->flash('success', trans('user.msg.import-success'));

            return redirect()->action('Admin\UserController@index');
        } catch (\Exception $e) {
            return response()->json('result', false);
        }
    }

    public function saveImport(Request $request)
    {
        $nameFile = $request->nameFile;
        DB::beginTransaction();
        try {
            $members = Report::importFileExcel($nameFile)->toArray();

            foreach ($members as $user) {
                $insert = $this->dataMember($user);
                //insert password
                $password = str_random(8);
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
        $data['avatar']= 'avatar.jpg';
        $data['birthday'] = $member['birthday'];
        $data['position_id'] = $member['position'];
        return $data;
    }

    public function getMember($teamId, $position, $positionTeams)
    {
        $user = $this->user;
        // team
        if ($teamId != 0) {
            $user = $user->whereHas('teamUsers.team', function ($query) use ($teamId) {
                $query->where('team_id', $teamId);
            });
        } else {
            $user = $user->with('teamUsers.team');
        }

        // position
        if ($position != 0) {
            $user = $user->with('position')->where('position_id', $position);
        } else {
            $user = $user->with('position');
        }

        //positionTeams
        if ($positionTeams != 0) {
            $user = $user->whereHas('teamUsers.positions', function ($query) use ($positionTeams) {
                $query->where('position_id', $positionTeams);
            });
        } else {
            $user = $user->with('teamUsers.positions');
        }

        return $user;
    }
}
