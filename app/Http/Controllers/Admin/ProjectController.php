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
use DB;

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
        // $projects = ProjectTeam::with('teamUser.team', 'teamUser.user', 'project')->where('is_leader', '=', 1)->paginate(15);
        $projects = $this->project->with(['projectTeams.user','projectTeams.teamUser.team','projectTeams.teamUser.user','projectTeams'=> function($query) {
            $query->where('is_leader', '=', 1);
        }] )->paginate(15);
        // $projects = $this->project->with('teamUsers.team', 'teamUsers.user', 'teamUsers')->orderBy('created_at', 'desc')->paginate(15);
        // $projects = TeamUser::with('projects', 'user', 'team')->get();
        // $projects = Project::all();
        //      dd($projects->toArray());
        $teams = Library::getTeams();

        // dd($projects);

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

        $arrTeam = $userTeams->map(function ($item, $key) {
            return $item->teamUser->team->id;
        });
         $arrTeam = $arrTeam->toArray();

        $listTeams = Team::with('users')->whereIn('id', $arrTeam)->get();

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
                // dd($request->all());

                $userTeams = TeamUser::with('user')->where('team_id', $teamId)->get();

                $userId = $userTeams->pluck('user_id')->all();
                $members = User::whereIn('id', $userId)->pluck('name', 'id')->all();

                $arrMember = array();
                if($flag == 0) {
                    $teamUserId = $userTeams->pluck('id')->all();
                    $userTeamId = ProjectTeam::with('teamUser.user')->where('project_id', $projectId)->pluck('team_user_id')->all();
                    $arrMember = TeamUser::with('user')->whereIn('id', $userTeamId)->where('team_id', $teamId)->pluck('user_id')->all();
                }
                // dd($arrMember);
                if(!$userTeams->isEmpty()) {
                    $html = view('admin.project.list_members', compact('userTeams', 'projectId', 'members', 'teamId', 'arrMember', 'flag'))->render();
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
                if($teamId != 0) {
                    $projects = $this->project->with(['projectTeams.user','projectTeams.teamUser.team' => function($query) use ($teamId) {
                                $query->where('team_id', '=', $teamId);
                            }],'projectTeams.teamUser.user'])
                            ->with(['projectTeams'=> function($query) {
                                $query->where('is_leader', '=', 1);
                            }])->paginate(15);
                    // $teamUser = TeamUser::where('team_id', $teamId)->pluck('id')->all();
                    // $projects = ProjectTeam::with('project', 'teamUser.team', 'teamUser.user')->whereIn('team_user_id', $teamUser)->where('is_leader', '=', 1)->orderBy('created_at', 'desc')->paginate(15);
                } else {
                    $projects = $this->project->with(['projectTeams.user','projectTeams.teamUser.team','projectTeams.teamUser.user','projectTeams'=>function($query) {
                        $query->where('is_leader', '=', 1);
                    }] )->paginate(15);
                }

                $html = view('admin.project.table_result', compact('projects'))->render();

                return response()->json(['html' => $html]);
            }catch(Exception $e){
                return response()->json('result', 400);
            }
        }
    }
}
