<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PositionTeam extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_team_id',
        'position_id',
    ];
}
