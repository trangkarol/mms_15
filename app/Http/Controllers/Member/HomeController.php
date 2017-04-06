<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\ProjectTeam;
use App\Helpers\Library;
use App\Models\Activity;
use Auth, DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $user = User::with('skills', 'position')->findOrFail($userId);
        $teamUsers = TeamUser::with('team', 'user', 'positions')->where('team_users.user_id', $userId )->get();
        $teamUserId = $teamUsers->pluck('id')->all();
        $projects = ProjectTeam::with('teamUser.team', 'project')->whereIn('team_user_id', $teamUserId)->get();
        $positions = Library::getPositions();

        return view('public.index', compact('user', 'teamUsers', 'projects', 'positions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listTeam()
    {
        $teams = Team::with('leader')->paginate(15);
        return view('public.list_team', compact('teams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listMember($teamId)
    {
        $nameTeam = Team::findOrFail($teamId)->pluck('name')->all();
        $members = TeamUser::with('positions', 'user')->where('team_users.team_id', $teamId)->paginate(15);

        return view('public.list_member', compact('members', 'nameTeam'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailMember($userId)
    {
        $user = User::with('skills', 'position')->findOrFail($userId);
        $teamUsers = TeamUser::with('team', 'user', 'positions')->where('team_users.user_id', $userId )->get();
        $teamUserId = $teamUsers->pluck('id')->all();
        $projects = ProjectTeam::with('teamUser.team', 'project')->whereIn('team_user_id', $teamUserId)->get();
        $positions = Library::getPositions();

        return view('public.index', compact('user', 'teamUsers', 'projects', 'positions'));
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
            $user = User::find($request->userId);
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
            $activity = new Activity;
            $activity->insertActivities($user, 'update');
            $request->session()->flash('success', trans('user.msg.update-success'));
            DB::commit();

            return redirect()->action('Member\HomeController@detailMember', $request->userId);
        } catch(\Exception $e) {
            $request->session()->flash('fail', trans('user.msg.update-fail'));
            DB::rollback();

            return redirect()->action('Member\HomeController@detailMember', $request->userId);
        }
    }
}
