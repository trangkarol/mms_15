<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class Activities extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 'users_id','target_id','target_type','action'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
    // 1 activities : 1 users
    public function users()
    { 
        return $this->belongsTo('App\Models\User');
    }
    // 1 activities : 1 users
    public function skills()
    { 
        return $this->belongsTo('App\Models\Skills');
    }
    // 1 activities : 1 projects
    public function projects()
    { 
        return $this->belongsTo('App\Models\Projects');
    }
    // 1 activities : 1 teams
    public function teams()
    { 
        return $this->belongsTo('App\Models\Teams');
    }
    // 1 activities : 1 users_teams
    public function users_teams()
    { 
        return $this->belongsTo('App\Models\UsersTeams');
    }
}
