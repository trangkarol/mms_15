<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Position::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'short_name' => $faker->name,
        'type_position' => $faker->numberBetween(1, 2),
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $positionId;

    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('123456'),
        'avatar' => "avatar.jpg",
        'birthday' => $faker->dateTime($max = 'now'),
        'role' => $faker->numberBetween(0, 1),
        'position_id' => $faker->randomElement($positionId ?: $positionId = App\Models\Position::where('type_position', 1)->pluck('id')->toArray()),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Skill::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Models\Team::class, function (Faker\Generator $faker) {
    static $userId;

    return [
        'name' => $faker->name,
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::pluck('id')->toArray()),
        'description' => str_random(255),
    ];
});

$factory->define(App\Models\Project::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'short_name' => $faker->name,
        'start_day' => $faker->dateTime(),
        'end_day' => $faker->dateTime(),
    ];
});

$factory->define(App\Models\PositionTeam::class, function (Faker\Generator $faker) {
    static $positionId;
    static $userTeamId;

    return [
        'team_user_id' => $faker->randomElement($userTeamId ?: $userTeamId = App\Models\TeamUser::pluck('id')->toArray()),
        'position_id' => $faker->randomElement($positionId ?: $positionId = App\Models\Position::where('type_position', 2)->pluck('id')->toArray()),
    ];
});

$factory->define(App\Models\ProjectTeam::class, function (Faker\Generator $faker) {
    static $projectId;
    static $userTeamId;

    return [
        'team_user_id' => $faker->randomElement($userTeamId ?: $userTeamId = App\Models\TeamUser::pluck('id')->toArray()),
        'project_id' => $faker->randomElement($projectId ?: $projectId = App\Models\Project::pluck('id')->toArray()),
        'is_leader' => $faker->numberBetween(0, 1),
    ];
});

$factory->define(App\Models\SkillUser::class, function (Faker\Generator $faker) {
    static $skillId;
    static $userId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::pluck('id')->toArray()),
        'skill_id' => $faker->randomElement($skillId ?: $skillId = App\Models\Skill::pluck('id')->toArray()),
        'level' => $faker->numberBetween(1, 4),
        'experiensive' => $faker->text,
    ];
});

$factory->define(App\Models\TeamUser::class, function (Faker\Generator $faker) {
    static $teamId;
    static $userId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::pluck('id')->toArray()),
        'team_id' => $faker->randomElement($teamId ?: $teamId = App\Models\Team::pluck('id')->toArray()),
    ];
});

$factory->define(App\Models\Activity::class, function (Faker\Generator $faker) {
    static $userId;

    return [
        'user_id' => $faker->randomElement($userId ?: $userId = App\Models\User::pluck('id')->toArray()),
        'action' => array_rand(['Isert', 'Update', 'Delete']),
    ];
});
