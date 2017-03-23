<?php

namespace App\Helpers;
use App\Models\Team;
use App\Models\Skill;
use App\Models\Position;
use App\Models\Project;
use App\Models\User;
use Cache;

class Library {
    public static function getLibraryTeams()
    {
        return Cache::remember('teams', config('view.minutes'), function() {
            return Team::pluck('name', 'id')->all();
        });
    }

    public static function getLibrarySkills()
    {
        return Cache::remember('skills', config('view.minutes'), function() {
            return Skill::pluck('name', 'id')->all();
        });
    }

    public static function getLibraryPositions()
    {
        return Cache::remember('positions', config('view.minutes'), function() {
            return Position::pluck('name', 'id')->all();
        });
    }

    public static function getLibraryProjects()
    {
        return Cache::remember('project', config('view.minutes'), function() {
            return Project::pluck('name', 'id')->all();
        });
    }

    public static function getLibraryUsers()
    {
        return Cache::remember('user', config('view.minutes'), function() {
            return User::pluck('name', 'id')->all();
        });
    }
}
