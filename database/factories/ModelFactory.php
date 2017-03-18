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
/** */
$factory->define(App\Models\Position::class, function (Faker\Generator $faker) {
    return [
        'name' 			=> $faker->name,
        'short_name' 	=> $faker->name,
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' 			=> $faker->name,
        'email' 		=> $faker->unique()->safeEmail,
        'password' 		=> $password ?: $password = bcrypt('123456'),
        'birthday'		=> $faker->date(),
        'role'			=> randomDigit,
        'position_id'	=> function () {
            	return factory(App\Models\User::class)->create()->id;
        },
        'deleted_at'		=> str_random(10),
        'remember_token' 	=> str_random(10),
    ];
});
