<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_users')->withTimestamps();;
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitiable');
    }

    public function leader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }
}
