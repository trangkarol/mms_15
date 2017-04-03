<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use Carbon\Carbon;

class Activity extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'activitiable_id',
        'activitiable_type',
        'action',
    ];

    // Relation::morphMap([
    //     'user' => User::class,
    //     'teams' => Teams::class,
    // ]);

    protected $appends = ['description'];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function insertActivities($model, $action)
    {
        $model->activities()->create([
            'user_id' => 1,//Auth::user()->id,
            'action' => $action,
        ]);
    }

    public function getDescriptionAttribute()
    {
        return $this->user->name.' '.$this->action.' '.$this->activitiable_type.' have name is '.$this->activitiable->name.' at '.$this->created_at;
    }
}
