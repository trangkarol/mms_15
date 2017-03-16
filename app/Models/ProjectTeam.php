<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    protected $table = 'project_team';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_team_id',
        'position_id',
        'is_leader',
    ];
}
