<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 
        'user_id',
        'activitiable_id',
        'activitiable_type',
        'action',
    ];

    /**

     * The attributes that should be mutated to dates.

     *

     * @var array

     */
    
    protected $dates = ['deleted_at'];
    
    public function activitiable()
    { 
        return $this->morphTo();
    }
}
