<?php

use Illuminate\Database\Seeder;

class ProjectTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProjectTeam::class, 10)->create();
    }
}
