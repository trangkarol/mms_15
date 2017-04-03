<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Skill extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_users')->withPivot('level', 'experiensive')->withTimestamps();
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'activitiable');
    }

    public function skillUsers()
    {
       return $this->hasMany(SkillUser::class);
    }

    public function scopeSkillId($query, $arrSkillId)
    {
        return $query->whereIn('id', $arrSkillId);
    }
}
