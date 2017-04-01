<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'birthday',
        'role',
        'position_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_users')->withPivot('level', 'experiensive')->withTimestamps();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_users')->withTimestamps();;
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitiable');
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public function isAdmin()
    {
        return $this->role == config('setting.role.admin');
    }

    public function isUser()
    {
        return $this->role == config('setting.role.user');
    }

    public function leader()
    {
        return $this->belongsTo(Team::class);
    }

    public function teamUsers()
    {
        return $this->hasMany(TeamUser::class);
    }
}
