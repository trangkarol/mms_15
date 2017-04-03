<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Controllers\Controller;
use \Illuminate\Pagination\Paginator;
use App\Http\Requests\User\InsertUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
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
use Mail, DB;
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
    public function __construct(User $user, Activity $activity)
    {
        $this->user = $user;
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Mail::to('thientrang2808@gmail.com')->send(new SendPassword());
        // dd('hello');
        $teams = Library::getLibraryTeams();
        $position = Library::getPositions();
        $positionTeams = Library::getPositionTeams();
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
        $positions = Library::getPositions();
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
            // dd($request->all());
            $this->user->name = $request->name;
            $this->user->email = $request->email;
            $this->user->birthday = date_create($request->birthday);
            $password = str_random(8);

            $this->user->password = bcrypt($password);
            $this->user->role = $request->role;

            //images
            $this->user->avatar = Library::importFile($request->file);

            $this->user->position()->associate($request->position);
            $this->user->save();

            $this->activity->insertActivities($this->user, 'insert');
            $request->session()->flash('success', trans('user.msg.insert-success'));

            // send password to user
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ];

            Mail::to($request->email)->queue(new SendPassword($data));
            DB::commit();

            return redirect()->action('Admin\UserController@edit', $this->user->id);
        } catch(\Exception $e) {
            dd($e);
            $request->session()->flash('fail', trans('user.msg.insert-fail'));
            DB::rollback();

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $levels = Library::getLevel();
        $positions = Library::getPositions();
        $skills = Library::getLibrarySkills();
        $skillUsers = SkillUser::skillUsers($id)->get();
        $skillId = $skillUsers->pluck('skill_id')->all();

        // team
        $teams = Library::getLibraryTeams();
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
            // dd($request->all());
            $user = $this->user->find($request->userId);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->birthday = $request->birthday;
            $user->role = $request->role;

            if (isset($request->file)) {
                if($user->avatar != "avatar.jpg" && !is_null($user->avatar)) {
                    $urlAvartar = base_path().'/public/Upload/'.$user->avatar;
                    unlink($urlAvartar);
                }

                $user->avatar = Library::importFile($request->file);
            }

            $user->position()->associate($request->position);
            $user->save();

            $this->activity->insertActivities($user, 'update');
            $request->session()->flash('success', trans('user.msg.update-success'));
            DB::commit();

            return redirect()->action('Admin\UserController@edit', $request->userId);
        } catch(\Exception $e) {            dd($e);
            $request->session()->flash('fail', trans('user.msg.update-fail'));
            DB::rollback();

            return redirect()->action('Admin\UserController@edit', $request->userId);
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
            //get team user id ->pluck('id')->all()
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
        } catch(\Exception $e) {
            dd($e);
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
        if ($request->ajax()) {
            try{
                // dd($request->all());
                $teamId = $request->teamId;
                $position = $request->position;
                $positionTeams = $request->positionTeams;
                $user = $this->getMember($teamId, $position, $positionTeams);

                $members  = $user->orderBy('created_at', 'desc')->paginate(15);
                // dd($members->toArray());

                $html = view('admin.user.table_result', compact('members'))->render();

                return response()->json(['result' => true, 'html' => $html]);
            }catch(Exception $e){
                return response()->json('false', false);
            }
        }
    }

    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function addSkill(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try{
                // dd($request->all());
                $userId = $request->userId;
                $skill = $request->skillId;
                $exeper = $request->exeper;
                $level = $request->level;
                $flag = $request->flag;

                if($flag == 0) {//insert user skill
                    $userSkill = SkillUser::where('skill_id', $skill)->where('user_id', $userId)->delete();
                }

                if($flag == 1 || $flag == 0) {
                    $userSkill = $this->user->find($userId);
                    $userSkill->skills()->attach([$skill=>[
                        'experiensive' => $exeper,
                        'level' => $level
                        ]]);
                }

                $skillUsers = SkillUser::skillUsers($userId)->get();

                $levels = Library::getLevel();
                $html = view('admin.user.list_skill', compact('skillUsers', 'levels'))->render();

                DB::commit();
                return response()->json(['result' => true, 'html' => $html]);
            }catch(Exception $e){
                DB::rollback();
                return response()->json('result', false);
            }
        }
    }


    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteSkill($skillId, $userId)
    {
        DB::beginTransaction();
        try {
            $userSkill = SkillUser::where('skill_id', $skillId)->where('user_id', $userId)->delete();
            $skillUsers = SkillUser::skillUsers($userId)->get();

            $levels = Library::getLevel();
            $html = view('admin.user.list_skill', compact('skillUsers', 'levels'))->render();
            DB::commit();

            return response()->json(['result' => true, 'html' => $html]);
        } catch (Exception $e){
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
        if ($request->ajax()) {
            DB::beginTransaction();
            try{
                $userId = $request->userId;
                $teamId = $request->teamId;
                $flag = $request->flag;
                $arrPosition = [];
                // $arrProject = [];

                if($flag == 0 || $flag == 2) {
                    $teamUserId = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->pluck('id');
                    // positions
                    $arrPosition = PositionTeam::with('positions')->where('team_user_id', $teamUserId[0])->pluck('position_id')->all();
                    // projects
                    // $arrProject = ProjectTeam::getProject($teamUserId[0])->pluck('project_id')->all();

                }
                $positions = Library::getPositionTeams();
                // project
                // $projects = Library::getLibraryProjects();
                // $projectTeams = Library::getLibraryProjects();
                $html = view('admin.user.position_team', compact('positions', 'userId', 'teamId', 'flag', 'arrPosition'))->render();

                DB::commit();
                return response()->json(['result' => true, 'html' => $html]);
            }catch(Exception $e){
                DB::rollback();
                return response()->json('result', false);
            }
        }
    }

    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function addTeam(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();
            try{

                $userId = $request->userId;
                $teamId = $request->teamId;
                $positions = $request->positions;
                $flag = $request->flag;
                // dd($request->all());
                if($flag == 1) {
                    $team = $this->user->find($userId)->teams()->attach($teamId);
                }
                //
                $teamUserId = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->pluck('id')->all();

                $teamUser = TeamUser::find($teamUserId[0])->positions()->sync($positions);
                DB::commit();
                $teamUserIds = TeamUser::where('user_id', $userId)->pluck('id')->all();
                $positionTeams = TeamUser::with('team', 'positions')->whereIn('id', $teamUserIds)->get();
                // dd($positionTeams->toArray());

                $html = view('admin.user.team', compact('positionTeams'))->render();


                return response()->json(['result' => true, 'html' => $html]);
            }catch(Exception $e){
                DB::rollback();
                return response()->json('result', false);
            }
        }
    }

    /**
     * add skill
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteTeam($teamId, $userId)
    {
        DB::beginTransaction();
        try{
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
        }catch(Exception $e){
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
        if ($request->ajax()) {
            DB::beginTransaction();
            try{
                $userId = $request->userId;
                $skillId = $request->skillId;
                $flag = $request->flag;
                $arrPosition = [];
                // $arrProject = [];

                if($flag == 0 || $flag == 2) {
                    $userSkill = SkillUser::with('skill')->where('skill_id', $skillId)->where('user_id', $userId)->first();
                }

                $skills = Library::getLibrarySkills();
                $levels = Library::getLevel();
                // project
                // $projects = Library::getLibraryProjects();
                // $projectTeams = Library::getLibraryProjects();
                $html = view('admin.user.skill', compact('skills', 'levels', 'flag', 'userId', 'skillId', 'userSkill'))->render();

                DB::commit();
                return response()->json(['result' => true, 'html' => $html]);
            }catch(Exception $e){
                DB::rollback();
                return response()->json('result', false);
            }
        }
    }

    public function importFile(Request $request)
    {
        // if ($request->ajax()) {
            try{
                // dd($request->all());
                $report = new Report;
                $file = $request->file;
                $nameFile = '';
                if(isset($file)) {

                    $nameFile = Library::importFile($file);
                    $members = $report->importFileExcel($nameFile);
                     // dd($members);
                    $position = Library::getPositions();
                }

                // $html = view('admin.user.table_scv', compact('members', 'position'))->render();
                return view('admin.user.table_scv', compact('members', 'position', 'nameFile'));

                DB::commit();
                return response()->json(['result' => true, 'html' => $html]);
            }catch(Exception $e){
                DB::rollback();
                return response()->json('result', false);
            }
        // }
    }

    public function exportFile($type, $teamId, $position, $positionTeams)
    {
        // if ($request->ajax()) {
            try{
                $report = new Report;
                $dt = new DateTime();
                // dd($type,  $teamId, $position, $positionTeams);
                $user = $this->getMember($teamId, $position, $positionTeams);
                $members = $user->get();
                $nameFile = 'user'.$dt->format('Y-m-d-H-i-s');
                $report->exportFileExcel($members, $type, $nameFile);
                $urlFile = $nameFile.'.'.$type;

                return response()->json(['result' => true, 'urlFile' => storage_path($urlFile)]);
            }catch(\Exception $e){
                return response()->json('result', false);
            }
        // }
    }

    public function saveImport(Request $request)
    {

            DB::beginTransaction();
            try{
                $report = new Report;
                // dd($request->all());
                $nameFile = $request->nameFile;
                $members = $report->importFileExcel($nameFile)->toArray();
                // dd($members);
                // validate users

                foreach ($members as $user) {
                    // foreach ($member as $user) {
                        $insert = $this->dataMember($user);
                        //insert password
                        $password = str_random(8);
                        $insert['password'] = $password;

                        if(!$this->validator($insert)->validate()) {
                            Mail::to($insert['email'])->queue(new SendPassword($insert));
                            $insert['password'] = bcrypt($password);
                            $this->user->create($insert);
                        }
                    // }

                }

                $request->session()->flash('success', trans('user.msg.import-success'));

                DB::commit();
                return redirect()->action('Admin\UserController@index');
            }catch(\Exception $e){
                // dd($e['messages']);
                dd($e);
                $request->session()->flash('fail', trans('user.msg.import-fail'));
                DB::rollback();

                return redirect()->action('Admin\UserController@index');
            }
        // }
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
        $data['avatar']= "avatar.jpg";
        $data['birthday'] = $member['birthday'];
        $data['position_id'] = $member['position'];
        return $data;
    }

    public function getMember($teamId, $position, $positionTeams)
    {
        $user = $this->user;
        // team
        if ($teamId != 0) {
            $user = $user->whereHas('teamUsers.team', function($query) use ($teamId) {
                        $query->where('team_id',  $teamId);
                    });
        } else {
            $user = $user->with('teamUsers.team');
        }

        // position
        if($position != 0) {
            $user = $user->with('position')->where('position_id', $position);
        } else {
            $user = $user->with('position');
        }

        //positionTeams
        if($positionTeams != 0) {
            $user = $user->whereHas('teamUsers.positions', function($query) use($positionTeams) {
                $query->where('position_id', $positionTeams);
            });
        } else {
            $user = $user->with('teamUsers.positions');
        }

        return $user;
    }
}
