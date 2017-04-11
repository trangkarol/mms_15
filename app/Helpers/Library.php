<?php

namespace App\Helpers;

use App\Models\Team;
use App\Models\Skill;
use App\Models\Position;
use App\Models\Project;
use App\Models\User;
use DateTime;
use Mail;
use Cache;

class Library
{
    public static function getLibraryTeams()
    {
        return Cache::remember('teams', config('view.minutes'), function () {
            return Team::pluck('name', 'id')->all();
        });
    }


    public static function getLibrarySkills()
    {
        return  Cache::remember('skills', config('view.minutes'), function () {
            return Skill::pluck('name', 'id')->all();
        });
    }

    public static function getPositions()
    {
        return Cache::remember('positions', config('view.minutes'), function () {
            return Position::where('type_position', config('view.position_company'))->pluck('name', 'id')->all();
        });
    }

    public static function getLibraryProjects()
    {
        return Cache::remember('project', config('view.minutes'), function () {
            return Project::pluck('name', 'id')->all();
        });
    }

    public static function getLibraryUsers()
    {
        return Cache::remember('user', config('view.minutes'), function () {
            return User::pluck('name', 'id')->all();
        });
    }

    public static function getPositionTeams()
    {
        return Cache::remember('positions', config('view.minutes'), function () {
            return Position::where('type_position', config('view.position_team'))->pluck('name', 'id')->all();
        });
    }

    public static function getTypePosition()
    {
        return  [
            '1' => 'Position',
            '2' => 'Position Team',
        ];
    }

    public static function getLevel()
    {
        return  [
            '1' => 'Junior',
            '2' => 'Senior',
        ];
    }

    public static function importFile($file, $name)
    {
        $nameFile = config('setting.avatar_default');
        if (isset($file)) {
            $dt = new DateTime();
            $files = explode('.', $file->getClientOriginalName());
            $nameFile = $name . $dt->format('Y-m-d-H-i-s') . '.' . $files[count($files) - 1];
            $file->move(config('setting.url_upload'), $nameFile);
        }

        return $nameFile;
    }

    public static function deleteFile($avatar)
    {
        if ($avatar != config('setting.avatar_default')) {
            unlink(config('setting.url_upload') . $avatar);
        }
    }
}
