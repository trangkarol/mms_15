<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
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

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function teamUser()
    {
        return $this->belongsTo(TeamUser::class);
    }

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetProject($query, $value)
    {
        return $query->with('projects')->whereIn('team_user_id', $value);
    }
}
