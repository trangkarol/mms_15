<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class Projects extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_project', 'short_name','start_day','end_day'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
    //1 projects : n activities
    public function activities()
    {
        
       return $this->hasMany('App\Models\Activities');
    }
    //n projects:n users_teams
    public function users_teams()
    {
        return $this->belongsToMany('App\Models\UsersTeams');
    }
}
