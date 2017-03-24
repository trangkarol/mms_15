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

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function teamUser()
    {
        return $this->belongsTo(TeamUser::class);
    }

    public function scopeGetId($query, $value)
    {
        return $query->whereIn('team_user_id', $value);
    }
}
