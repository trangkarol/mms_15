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
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ReportController as Report;
use App\Http\Requests\Team\InsertRequest;
use DB, DateTime;
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
        $teams = $this->team->orderBy('created_at', 'desc')->paginate(15);

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
        $teams = $this->team->with('leader','teamUsers.user', 'teamUsers.positions', 'teamUsers.projectTeams.project')->where('id', $id)->first();
        // dd($teams->toArray());
        return view('admin.team.detail', compact('teams'));
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

            $teamUser = TeamUser::getTeam($request->teamId);
            $teamUserId = $teamUser->pluck('id');

            PositionTeam::getId($teamUserId)->delete();
            ProjectTeam::getId($teamUserId)->delete();
            $teamUser->delete();
            $team->delete();
            $this->activity->insertActivities($team, 'delete');

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
            } else {
                $this->activity->insertActivities($team, 'edit members to team');
            }

            $teamUser = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->with('positions')->pluck('id')->all();
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
            $teamUser = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->with('positions')->pluck('id')->first();
            $arrPosition = [];
            if(!empty($teamUser)) {
                $arrPosition = PositionTeam::where('team_user_id', $teamUser)->pluck('position_id')->all();
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

            // dd($request->all());

            $memberTeam = TeamUser::where('team_id', $teamId)->pluck('user_id')->toArray();

            $users = SkillUser::with('user');

            if(!is_null($skills) && !is_null($levels)) {
                // $users = User::with(['skills' => function($query) use ($levels, $skills) {
                //     $query->whereIn('level', $levels)->orWhereIn('skill_id', $skills);
                // }]);

                $users =  $users->whereIn('level', $levels)->WhereIn('skill_id', $skills);

            } elseif(!is_null($skills) && is_null($levels)) {

                    // $users = User::with(['skills' => function($query) use ( $skills) {
                    //     $query->whereIn('skill_id', $skills);
                    // }]);
                    $users = $users->whereIn('skill_id', $skills);

                } elseif(!is_null($levels) && is_null($skills)) {

                    // $users = User::with(['skills' => function($query) use ( $levels) {
                    //     $query->whereIn('level', $levels);
                    // }]);

                    $users =  $users->whereIn('level', $levels);

                }

            if(!is_null($memberTeam)) {
                $users = $users->whereNotIn('user_id', array_flatten($memberTeam));
            }

            $userSkills = $users->get();
            // dd($userSkills->toArray());
            $html = view('admin.team.search_user', compact('userSkills'))->render();

            return response()->json(['result' => true, 'html' => $html]);
        } catch(\Exception $e) {
            dd($e);
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
            $members = TeamUser::with('positions', 'team', 'user')->where('team_users.team_id', '=', $teamId)->get();

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

            $teamUser = TeamUser::where('team_id', $teamId)->where('user_id', $userId)->with('positions')->pluck('id')->all();
            $projectTeam = ProjectTeam::where('team_user_id', $teamUser[0])->delete();
            $positionTeam = PositionTeam::where('team_user_id', $teamUser[0])->delete();

            $team = $this->team->findOrFail($teamId);
            $team->users()->detach($userId);

            $this->activity->insertActivities($team, 'delete members to team');
            DB::commit();

            return response()->json(['result' => true]);
        } catch(\Exception $e) {
            DB::rollback();
            dd($e);
           return response()->json(['result' => false]);
        }
    }

    public function importFile(Request $request)
    {
        try{
            $report = new Report;
            $file = $request->file;
            $nameFile = '';
            if(isset($file)) {
                $nameFile = Library::importFile($file);
                $teams = $report->importFileExcel($nameFile);
            }
            return view('admin.export.team.import_data', compact('teams', 'nameFile'));
        }catch(\Exception $e){
            dd($e);
            return redirect()->action('Admin\TeamController@index');
        }
    }

    public function exportFile(Request $request)
    {
        try{
            $report = new Report;
            $dt = new DateTime();

            $type = $request->type;
            $teams = Team::all();
            $nameFile = 'team'.$dt->format('Y-m-d-H-i-s');
            $report->exportTeamFileExcel($teams, $type, $nameFile);
                unlink( base_path().'/public/Upload/'.$nameFile );
            $request->session()->flash('success', trans('team.msg.import-success'));
            return redirect()->action('Admin\TeamController@index');
        }catch(\Exception $e){
                dd($e);
            $request->session()->flash('fail', trans('team.msg.import-fail'));
            return redirect()->action('Admin\TeamController@index');
        }
    }

    public function saveImport(Request $request)
    {

        DB::beginTransaction();
        try{
            $report = new Report;
            $nameFile = $request->nameFile;
            $teams = $report->importFileExcel($nameFile)->toArray();
            // validate users
            foreach ($teams as $team) {
                $insert = $this->dataTeam($team);

                if(!$this->validator($insert)->validate()) {
                    $team = $this->team->create($insert);
                    $this->activity->insertActivities($team, 'insert');
                }
            }

            $request->session()->flash('success', trans('team.msg.import-success'));

            DB::commit();
            return redirect()->action('Admin\TeamController@index');
        }catch(\Exception $e){
            $request->session()->flash('fail', trans('team.msg.import-fail'));
            DB::rollback();

            return redirect()->action('Admin\TeamController@index');
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
            'user_id' => 'required',
        ]);
    }

    /**
     *data Member.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function dataTeam($team)
    {
        $data = [];
        $data['name'] = $team['name'];
        $data['user_id'] = $team['leader'];
        $data['description'] = $team['description'];
        return $data;
    }
}


