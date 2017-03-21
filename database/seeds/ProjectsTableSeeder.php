<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Project::class, 10)->create()->each(function ($project) {
            foreach(range(1, 2) as $key) {
                $activities[] = factory(App\Models\Activity::class)->make()->toArray();
            }

           $project->activities()->createMany($activities);
        });
    }
}
