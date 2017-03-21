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
        factory(App\Models\User::class, 10)->create()->each(function ($user) {
            foreach(range(1, 2) as $key) {
                $activities[] = factory(App\Models\Activity::class)->make()->toArray();
            }

           $user->activities()->createMany($activities);
        });
    }
}
