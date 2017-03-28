<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Library;
use App\Models\Team;
use App\Models\User;
use App\Models\Activity;
use App\Models\TeamUser;
use App\Models\SkillUser;
use App\Models\Position;
use App\Models\PositionTeam;
use App\Models\ProjectTeam;
use App\Http\Requests\Team\InsertRequest;
use DB;
use Carbon\Carbon;

class TeamController extends Controller
{
    protected $team;
    protected $activity;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Team $team, Activity $activity)
    {
        $this->team = $team;
        $this->activity = $activity;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teams = $this->team->paginate(15);

        return view('admin.team.index', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leader = Library::getLibraryUsers();

        return view('admin.team.create', compact('leader'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertRequest $request)
    {
        DB::beginTransaction();

        try {
            $this->team->name = $request->name;
            $this->team->description = $request->description;
            $this->team->leader()->associate($request->leader);
            $this->team->save();
            $this->activity->insertActivities($this->team, 'insert');
            $request->session()->flash('success', trans('team.msg.insert-success'));
            DB::commit();

            return redirect()->action('Admin\TeamController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('team.msg.insert-fail'));
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
        $team = $this->team->findOrFail($id);
        $leader = Library::getLibraryUsers();

        return view('admin.team.edit', compact('leader', 'team'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InsertRequest $request)
    {
        DB::beginTransaction();
        try {
            $team = $this->team->findOrFail($request->teamId);
            $team->name = $request->name;
            $team->description = $request->description;
            $team->leader()->associate($request->leader);
            $team->update();
            $this->activity->insertActivities($team, 'update');
            $request->session()->flash('success', trans('team.msg.update-success'));
            DB::commit();

            return redirect()->action('Admin\TeamController@index');
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('team.msg.update-fail'));
            DB::rollback();

            return redirect()->action('Admin\TeamController@index');
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
            $team = $this->team->findOrFail($request->teamId);
            $this->activity->insertActivities($team, 'delete');
            $team->delete();
            $request->session()->flash('success', trans('team.msg.delete-success'));
            DB::commit();

            return redirect()->action('Admin\TeamController@index');
        } catch(Exception $e) {
            $request->session()->flash('fail', trans('team.msg.delete-fail'));
            DB::rollback();

            return redirect()->action('Admin\TeamController@index');
        }
    }

    /**
     * get page add member
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addMember()
    {
        $teams = Library::getLibraryTeams();;
        $skills = Library::getLibrarySkills();

        return view('admin.team.team_users', compact('teams', 'skills'));
    }

    /**
     *  page add member
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeMember(Request $request)
    {
        DB::beginTransaction();

        try {
            // dd($request->all());
            $teamId = $request->teamId;
            $userId = $request->userId;
            $positions = $request->positions;
            $team = $this->team->findOrFail($teamId);
            if($request->flag == 1) { //when flag is add
                $team->users()->attach($userId);
                $this->activity->insertActivities($team, 'add members to team');
            } else { //when flag is edit
                $this->activity->insertActivities($team, 'edit members to team');
            }

            $teamUser = TeamUser::getTeam($teamId)->getUser($userId)->with('positions')->pluck('id')->all();
            $positionTeam = TeamUser::findOrFail($teamUser[0])->positions()->sync($positions);
            DB::commit();

            return response()->json(['result' => true]);
        } catch(\Exception $e) {
            DB::rollback();

           return response()->json(['result' => false]);
        }
    }

    /**
     *  edit position member
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function positionTeam(Request $request)
    {
        DB::beginTransaction();

        try {
            $teamId = $request->teamId;
            $userId = $request->userId;
            $teamUser = TeamUser::getTeam($teamId)->getUser($userId)->with('positions')->pluck('id')->all();
            $arrPosition = [];
            if(!empty($teamUser)) {
                $arrPosition = PositionTeam::teamUserId($teamUser[0])->pluck('position_id')->all();
            }

            $positions = Library::getPositionTeams();

            $html = view('admin.team.insert_positon_teams', compact('positions', 'teamId', 'userId', 'teamUser', 'arrPosition', 'positions'))->render();

            return response()->json(['result' => true, 'html' => $html]);
        } catch(\Exception $e) {
            DB::rollback();
           return response()->json(['result' => false]);
        }
    }

    /**
     * search the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        try {
            $skills = $request->skills;
            $levels = $request->levels;
            $teamId = $request->teamId;

            $memberTeam = TeamUser::getTeam($teamId)->pluck('user_id')->toArray();

            $users = new User;

            if(!is_null($skills) && !is_null($levels)) {
               $users = User::with(['skills' => function($query) use ($levels, $skills) {
                    $query->whereIn('level', $levels)->whereIn('skill_id', $skills);
                }]);

            } elseif(!is_null($skills) && is_null($levels)) {

                    $users = User::with(['skills' => function($query) use ( $skills) {
                        $query->whereIn('skill_id', $skills);
                    }]);
                } elseif(!is_null($levels) && is_null($skills)) {

                    $users = User::with(['skills' => function($query) use ( $levels) {
                        $query->whereIn('level', $levels);
                    }]);
                }

            if(!is_null($memberTeam)) {
                $users = $users->whereNotIn('id', array_flatten($memberTeam));
            }

            $users = $users->get();
            $html = view('admin.team.search_user', compact('users'))->render();

            return response()->json(['result' => true, 'html' => $html]);
        } catch(\Exception $e) {
           return response()->json(['result' => false]);
        }
    }

    /**
     * search the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchMember(Request $request)
    {
        try {
            $teamId = $request->teamId;
            $members = TeamUser::with('positions', 'team', 'user')->getTeam($teamId)->get();
            $html = view('admin.team.list_member', compact('members'))->render();

            return response()->json(['result' => true, 'html' => $html]);
        } catch(\Exception $e) {
           return response()->json(['result' => false]);
        }
    }

    /**
     *  page delete member
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteMember(Request $request)
    {
        DB::beginTransaction();

        try {
            $teamId = $request->teamId;
            $userId = $request->userId;

            $teamUser = TeamUser::getTeam($teamId)->getUser($userId)->with('positions')->pluck('id')->all();
            $projectTeam = ProjectTeam::teamUserId($teamUser[0])->delete();
            $positionTeam = PositionTeam::teamUserId($teamUser[0])->delete();

            $team = $this->team->findOrFail($teamId);
            $team->users()->detach($userId);

            $this->activity->insertActivities($team, 'delete members to team');
            DB::commit();

            return response()->json(['result' => true]);
        } catch(\Exception $e) {
            DB::rollback();
           return response()->json(['result' => false]);
        }
    }
}


