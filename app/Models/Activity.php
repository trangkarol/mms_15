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

    /**
     * Insert the specified resource from storage.
     *
     * @param  string  $action , model
     * @return \Illuminate\Http\Response
     */
    public function insertActivities($model, $action)
    {
        $model->activities()->create([
            'user_id' => 1,//Auth::user()->id,
            'action' => $action,
        ]);
    }
}
