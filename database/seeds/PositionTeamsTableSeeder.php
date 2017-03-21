<?php

use Illuminate\Database\Seeder;

class PositionTeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\PositionTeam::class, 10)->create();
    }
}
