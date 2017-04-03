<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'birthday' => '2017-03-12',
            'role' => 0,
            'position_id' => 1,
            'remember_token' => str_random(10),
        ]);
        factory(App\Models\User::class, 10)->create();
        // factory(App\Models\User::class, 10)->create()->each(function ($user) {
        //     foreach(range(1, 2) as $key) {
        //         $activities[] = factory(App\Models\Activity::class)->make()->toArray();
        //     }

        //    $user->activities()->createMany($activities);
        // });
    }
}
