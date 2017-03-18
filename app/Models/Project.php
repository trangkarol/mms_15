<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'short_name',
        'start_day',
        'end_day',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function activities()
    {  
        return $this->morphMany(Activity::class, 'activitiable');
    }

    public function teamUsers()
    {
        return $this->belongsToMany(TeamUser::class);
    }
    
}
