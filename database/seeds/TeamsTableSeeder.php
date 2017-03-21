<?php

use Illuminate\Database\Seeder;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Team::class, 10)->create()->each(function ($team) {
            foreach(range(1, 2) as $key) {
                $activities[] = factory(App\Models\Activity::class)->make()->toArray();
            }

           $team->activities()->createMany($activities);
        });
    }
}
