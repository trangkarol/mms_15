<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Team;
use App\Models\TeamUser;
use App\Models\ProjectTeam;
use Auth;

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
        $user = User::with('skills', 'position')->findOrFail($userId);//->where('id', $userId)->first();
        $teamUsers = TeamUser::with('team', 'user', 'positions')->where('team_users.user_id', $userId )->get();
        $teamUserId = $teamUsers->pluck('id')->all();
        $projects = ProjectTeam::with('teamUser.team', 'project')->whereIn('team_user_id', $teamUserId)->get();
        // dd($user->toArray());
        return view('public.index', compact('user', 'teamUsers', 'projects'));
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
        // dd($user->toArray());
        return view('public.index', compact('user', 'teamUsers', 'projects'));
    }
}
