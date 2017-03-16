<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class Position extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_postion', 'short_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
    // 1 postions : n users
    public function users()
    { 
        return $this->hasMany('App\Models\User');
    }
    //1 postions : n activities
    public function activities()
    { 
       return $this->hasMany('App\Models\Activities');
    }
    //n postions:n users_teams
    public function users_teams()
    {
        return $this->belongsToMany('App\Models\UsersTeams');
    }
}
