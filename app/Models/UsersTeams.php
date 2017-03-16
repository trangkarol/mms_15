<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class UsersTeams extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'teams_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
    //n users_teams:n position
    public function position()
    {
        return $this->belongsToMany('App\Models\Position');
    }
    //n users_teams:n projects
    public function projects()
    {
        return $this->belongsToMany('App\Models\Projects');
    }
}
