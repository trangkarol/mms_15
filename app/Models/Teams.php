<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class Teams extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_teams','description'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
    // n teams : n users
    public function users()
    { 
        return $this->belongsToMany('App\Models\User');
    }
    //1 teams : n activities
    public function activities()
    {
        
       return $this->hasMany('App\Models\Activities');
    }
}
