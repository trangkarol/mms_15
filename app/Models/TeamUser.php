<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamUser extends Model
{
    protected $table = 'team_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'team_id',
    ];

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
