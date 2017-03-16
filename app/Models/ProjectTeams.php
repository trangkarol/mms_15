<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeams extends Model
{
    protected $table  = 'projects_teams';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_teams_id', 'positions_id','is_leaders'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
}
