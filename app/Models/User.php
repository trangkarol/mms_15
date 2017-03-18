<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

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
        return $this->belongsToMany(Skill::class) 
                    ->withPivot(
                                'level', 
                                'experiensive'
                            );
    }

    public function teams()
    {    
        return $this->belongsToMany(Team::class);
    }

    public function activities()
    {    
        return $this->morphMany(
                                Activity::class, 
                                'activitiable'
                            );
    }

    public function position()
    {  
        return $this->belongsTo(Position::class);
    }
}
