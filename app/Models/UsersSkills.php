<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Models;

class UsersSkills extends Models
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'skills_id', 'level','experiensive'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       
    ];
}
