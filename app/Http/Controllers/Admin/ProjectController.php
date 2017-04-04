<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Library;
use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\User;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ReportController as Report;
use DB, DateTime;

class ProjectController extends Controller
{
    protected $project;
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Project $project, Activity $activity)
    {
        $this->project = $project;
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = $this->project->with(['projectTeams.user','projectTeams.teamUser.team','projectTeams.teamUser.user','projectTeams'=> function($query) {
            $query->where('is_leader', '=', 1);
        }] )->paginate(15);
        $teams = Library::getLibraryTeams();

        return view('admin.project.index', compact('projects', 'teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = Library::getLibraryTeams();

        return view('admin.project.create', compact('teams'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $this->project->name = $request->name;
            $this->project->short_name = $request->short_name;
            $this->project->start_day = $request->start_day;
            $this->project->end_day = $request->end_day;
            $this->project->save();
            $this->activity->insertActivities($this->project, 'insert');
            $request->session()->flash('success', trans('project.msg.insert-success'));
            DB::commit();

            return redirect()->action('Admin\ProjectController@edit',  $this->project->id);
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('project.msg.insert-fail'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $userTeams = ProjectTeam::with('teamUser.team','teamUser.user')->where('project_id', $id)->where('is_leader', 1)->get();
        if(!empty($userTeams)) {
            $arrTeam = $userTeams->map(function ($item, $key) {
                return $item->teamUser->team->id;
            });
             $arrTeam = $arrTeam->toArray();

            $listTeams = Team::with('users')->whereIn('id', $arrTeam)->get();
             // $listTeams = TeamUser::with('user', 'positions', 'team')->whereIn('team_id', $arrTeam)->get();
             // dd($listTeams->toArray());
        }

        // dd($listTeam);

        $teams = Library::getLibraryTeams();

        return view('admin.project.edit', compact('project', 'teams', 'arrTeam', 'listTeams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::beginTransaction();

        try {
            $project = Project::findOrFail($request->projectId);
            $project->name = $request->name;
            $project->short_name = $request->short_name;
            $project->start_day = $request->start_day;
            $project->end_day = $request->end_day;
            $project->update();
            $this->activity->insertActivities($project, 'update');
            $request->session()->flash('success', trans('project.msg.update-success'));
            DB::commit();

            return redirect()->action('Admin\ProjectController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('project.msg.update-fail'));
            DB::rollback();
            return redirect()->back();
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
            $id = $request->projectId;
            $projectTeam = ProjectTeam::where('project_id', $id)->delete();
            $project = $this->project->findOrFail($id);
            $project->delete();

            $this->activity->insertActivities($project, 'delete');
            $request->session()->flash('success', trans('project.msg.delete-success'));
            DB::commit();

            return redirect()->action('Admin\ProjectController@index');
        } catch(\Exception $e) {
            dd($e);
            $request->session()->flash('fail', trans('project.msg.delete-fail'));
            DB::rollback();

           return redirect()->action('Admin\ProjectController@index');
        }
    }

    /**
     * save a user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function searchMember(Request $request)
    {
        if ($request->ajax()) {
            try{
                $teamId = $request->teamId;
                $flag = $request->flag;
                $projectId = $request->projectId;
                $userTeams = TeamUser::with('user')->where('team_id', $teamId)->get();

                $userId = $userTeams->pluck('user_id')->all();

                $arrMember = array();
                if($flag == 0) {
                    $members = User::whereHas('teamUsers.team', function($query) use ($teamId) {
                                $query->where('team_id',  $teamId);
                            })->with( ['teamUsers.projects' => function($query) use ($projectId) {
                                $query->where('project_id', $projectId);
                            }])->paginate(50);;
                }
                // dd($arrMember);
                if(!$userTeams->isEmpty()) {

                    $skills = Library::getLibrarySkills();
                    $levels = Library::getLevel();
                    $positionTeam =  array_prepend(Library::getPositionTeams(), 'All')  ;

                    $html = view('admin.project.list_members', compact('userTeams', 'projectId', 'members', 'teamId', 'arrMember', 'flag', 'skills', 'levels', 'positionTeam'))->render();
                } else {
                    $html = '';
                }


                return response()->json(['html' => $html]);

            }catch(Exception $e){
                return response()->json('result', 400);
            }
        }
    }

    /**
     * save a user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function getListUser(Request $request)
    {
        if ($request->ajax()) {
            try{
                $teamId = $request->teamId;
                $skillId = $request->skills;
                $positionTeam = $request->positionTeam;
                $level = $request->level;
                $projectId = $request->projectId;

                $user = new User;

                if($teamId != 0 ) {
                    $user = $user->whereHas('teamUsers.team', function($query) use ($teamId) {
                                $query->where('team_id',  $teamId);
                            });
                }

                if( !empty($skillId) ) {
                    $user = $user->whereHas('skillUsers.skill', function($query) use ($skillId) {
                                $query->whereIn('skill_id',  $skillId);
                            });
                }

                if( !empty($level)) {
                    $user = $user->whereHas('skillUsers', function($query) use ($level) {
                                $query->whereIn('level',  $level);
                            });
                }

                if( $positionTeam != 0 ) {
                    $user = $user->with(['teamUsers.positionTeams' => function($query) use ($positionTeam) {
                                $query->where('position_id',  $positionTeam);
                            }]);
                }

                $members = $user->paginate(50);

                // get member exits
                $userTeamId = ProjectTeam::with('teamUser.user')->where('project_id', $projectId)->pluck('team_user_id')->all();
                $arrMember = TeamUser::with('user')->whereIn('id', $userTeamId)->where('team_id', $teamId)->pluck('user_id')->all();
                // dd($members->toArray());

                $html = view('admin.project.project_member', compact('members', 'arrMember'))->render();

                return response()->json(['result' => true,  'html' => $html]);

            }catch(Exception $e){
                return response()->json('result', 400);
            }
        }
    }

    /**
     * save a user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function addMember(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try{
                $projectId = $request->projectId;
                $userId = isset($request->userId) ? $request->userId : [];
                $leaderId = $request->leader;
                $teamId = $request->teamId;
                $flag = $request->flag;

                // dd($request->all());
                $teamUsers = TeamUser::whereIn('user_id', $userId)->getTeam($teamId)->pluck('id','user_id')->all();

                $arr_teamUserId = [];

                foreach ($teamUsers as $key => $value) {
                    if($key == $leaderId) {
                        $arr_teamUserId[] = ['is_leader' => 1, 'team_user_id' => $value];
                    } else {
                        $arr_teamUserId[] = ['is_leader' => 0, 'team_user_id' => $value];
                    }
                }
                $project = $this->project->find($projectId);
                if($flag == 1) {
                    $project->teamUsers()->attach($arr_teamUserId);
                } else {
                    $teamUserId = TeamUser::where('team_id',$teamId)->pluck('id')->all();
                    $projectId = ProjectTeam::where('project_id', $projectId)->whereIn('team_user_id', $teamUserId)->delete();
                    // dd($projectId);
                    $project->teamUsers()->attach($arr_teamUserId);
                }


                DB::commit();

                return response()->json(['result' => true]);
            }catch(Exception $e){
                DB::rollback();

                return response()->json('result', false);
            }
        }
    }

    /**
     * save a user
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function deleteMember(Request $request)
    {
        if ($request->ajax()) {
            DB::beginTransaction();

            try{
                // dd($request->all());
                $projectId = $request->projectId;
                $members = $request->members;
                $teamId = $request->teamId;

                $userTeamId = TeamUser::where('team_id', $teamId)->whereIn('user_id', $members)->pluck('id')->all();
                // $projectTeam = ProjectTeam::where('project_id', $projectId)->whereIn('team_user_id', $userTeamId)->pluck('id')->all();//->delete();

                $project = $this->project->findOrFail($projectId);

                $delete = $project->teamUsers()->detach($userTeamId);
                // dd($projectTeam);
                // $this->activity->insertActivities($project, 'delete members');
                DB::commit();

                return response()->json(['result' => true]);
            }catch(Exception $e){
                DB::rollback();

                return response()->json('result', false);
            }
        }
    }

    /**
     * search
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        if ($request->ajax()) {
            try{
                $teamId = $request->teamId;
                $startDay = $request->startDay;
                $endDay = $request->endDay;

                if($teamId != 0) {
                    $projects = $this->project->with('projectTeams.user','projectTeams.teamUser.team')->whereHas('projectTeams.teamUser', function($query) use ($teamId) {
                                $query->where('team_id', '=', $teamId);
                            })->with('projectTeams.teamUser.user');

                } else {
                    $projects = $this->project->with('projectTeams.user','projectTeams.teamUser.team','projectTeams.teamUser.user');
                }

                $projects = $projects->with(['projectTeams'=> function($query) {
                                $query->where('is_leader', '=', 1);
                            }])->where('start_day', '>=', $startDay)->where('end_day', '<=', $endDay)->paginate(15);

                $html = view('admin.project.table_result', compact('projects'))->render();

                return response()->json(['html' => $html]);
            }catch(Exception $e){
                return response()->json('result', 400);
            }
        }
    }

     public function importFile(Request $request)
    {
        try{
            // dd($request->all());
            $report = new Report;
            $file = $request->file;
            $nameFile = '';
            if(isset($file)) {
                $nameFile = Library::importFile($file);
                $projects = $report->importFileExcel($nameFile);
            }

            $request->session()->flash('success', trans('user.msg.import-success'));
            return view('admin.export.project.import_data', compact('projects', 'nameFile'));
            } catch(\Exception $e) {
                $request->session()->flash('fail', trans('user.msg.import-fail'));
                DB::rollback();
                return redirect()->action('Admin\UserController@index');
            }
    }

    public function exportFile(Request $request)
    {
            try{
                // dd($request->all());
                $report = new Report;
                $dt = new DateTime();

                $type = $request->type;
                $teamId = $request->teamId;
                $startDay = $request->startDay;
                $endDay = $request->endDay;

                if($teamId != 0) {
                    $projects = $this->project->with('projectTeams.user','projectTeams.teamUser.team')->whereHas('projectTeams.teamUser', function($query) use ($teamId) {
                                $query->where('team_id', '=', $teamId);
                            })->with('projectTeams.teamUser.user');

                } else {
                    $projects = $this->project->with('projectTeams.user','projectTeams.teamUser.team','projectTeams.teamUser.user');
                }

                $projects = $projects->with(['projectTeams'=> function($query) {
                                $query->where('is_leader', '=', 1);
                            }])->where('start_day', '>=', $startDay)->where('end_day', '<=', $endDay)->get();
                $nameFile = 'project_'.$dt->format('Y-m-d-H-i-s');
                $report->exportFileProjectExcel($projects, $type, $nameFile);//
                unlink( base_path().'/public/Upload/'.$nameFile );
                $request->session()->flash('success', trans('project.msg.export-success'));
                return redirect()->action('Admin\ProjectController@index');
            }catch(\Exception $e){
                dd($e);
                $request->session()->flash('fail', trans('project.msg.export-fail'));
                return redirect()->action('Admin\ProjectController@index');
            }
    }

    public function saveImport(Request $request)
    {

            DB::beginTransaction();
            try{
                $report = new Report;
                // dd($request->all());
                $nameFile = $request->nameFile;
                $projects = $report->importFileExcel($nameFile)->toArray();
                // validate users

                foreach ($projects as $project) {
                    // dd($project);
                    $insert = $this->dataProject($project);

                    if(!$this->validator($insert)->validate()) {

                        $project = $this->project->create($insert);
                        $this->activity->insertActivities($project, 'insert');
                    }
                }

                $request->session()->flash('success', trans('project.msg.import-success'));
                DB::commit();
                return redirect()->action('Admin\ProjectController@index');
            }catch(\Exception $e){
                dd($e);
                $request->session()->flash('fail', trans('project.msg.import-fail'));
                DB::rollback();

                return redirect()->action('Admin\ProjectController@index');
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
            'short_name' => 'required',
            'start_day' => 'required',
            'end_day' => 'required',
        ]);
    }

    /**
     *data Member.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function dataProject($project)
    {
        $data = [];
        $data['name'] = $project['name'];
        $data['short_name'] = $project['short_name'];
        $data['start_day']= $project['startday'];
        $data['end_day'] = $project['enday'];
        return $data;
    }
}
