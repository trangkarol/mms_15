<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class PositionsTeams extends Models
{
    protected $table  = 'positions_teams';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'users_teams_id', 'positions_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
