<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Position extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'short_name',
    ];

    /**

     * The attributes that should be mutated to dates.

     *

     * @var array

     */
    
    protected $dates = ['deleted_at'];
    
    public function users()
    { 
        return $this->hasMany(User::class);
    }

    public function activities()
    { 
        return $this->morphMany(
                                Activity::class, 
                                'activitiable'
                            );
    }

    public function teamUsers()
    {
        return $this->belongsToMany(
                                    TeamUser::class,
                                    'position_teams',
                                    'position_id',
                                    'team_user_id'
                                );
    }
}
