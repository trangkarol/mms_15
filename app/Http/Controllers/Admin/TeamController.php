<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Library;
use App\Models\Team;
use App\Models\Activity;
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
    public function getMember()
    {
        $teams = Library::getLibraryTeams();;
        $skills = Library::getLibrarySkills();

        return view('admin.team.team_users', compact('teams', 'skills'));
    }
}
