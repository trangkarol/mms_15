<?php

namespace App\Helpers;
use App\Models\Team;
use App\Models\Skill;
use App\Models\Position;
use App\Models\Project;
use App\Models\User;
use DateTime, Mail;
use Cache;

class Library {
    public static function getLibraryTeams()
    {
        return Cache::remember('teams', config('view.minutes'), function() {
            return Team::pluck('name', 'id')->all();
        });
    }

    public static function getTeams()
    {
        $teams = Cache::remember('teams', config('view.minutes'), function() {
            return Team::pluck('name', 'id')->all();
        });
        return array_prepend($teams, '----');
    }


    public static function getLibrarySkills()
    {
        return Cache::remember('skills', config('view.minutes'), function() {
            return Skill::pluck('name', 'id')->all();
        });
    }

    public static function getPositions()
    {
        return Cache::remember('positions', config('view.minutes'), function() {
            return Position::where('type_position', 1)->pluck('name', 'id')->all();
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

    public static function getPositionTeams()
    {
        return Cache::remember('positions', config('view.minutes'), function() {
            return Position::where('type_position', 2)->pluck('name', 'id')->all();
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

    public static function importFile($fileImages)
    {
        $imageName = 'avatar.jpg';

        if(isset($fileImages))
            {
                $dt = new DateTime();
                //
                $arr_images = explode('.', $fileImages->getClientOriginalName());
                //
                $imageName = 'users_'.$dt->format('Y-m-d-H-i-s').'.'. $arr_images[count($arr_images)-1];
                //
                $fileImages->move(base_path().'/public/Upload/', $imageName );
            }

            return $imageName;
    }

    public static function sendMail()
    {
        Mail::send('common.send_mail', $data, $callback);
    }
}
