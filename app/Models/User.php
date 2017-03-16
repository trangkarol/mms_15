<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
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
        'name_user', 'email', 'password','birthday','roles','positions_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    // n user : n skills
    public function skills()
    {
        
        return $this->belongsToMany('App\Models\Skills');
    }
    //n user:n teams
    public function teams()
    {
        
        return $this->belongsToMany('App\Models\Teams');
    }
    //1 users : n activities
    public function activities()
    {
        
       return $this->hasMany('App\Models\Activities');
    }
    // 1 users : 1 position
    public function position()
    {
        
        return $this->belongsTo('App\Models\Psition');
    }
}
