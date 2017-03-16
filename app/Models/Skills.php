<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class Skills extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_skills',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
    // n skills : n users
    public function users()
    { 
        return $this->belongsToMany('App\Models\User');
    }   
    //1 skills : n activities
    public function activities()
    {
       return $this->hasMany('App\Models\Activities');
    }
}
}
