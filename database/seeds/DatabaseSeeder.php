<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(PositionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        // $this->call(ProjectsTableSeeder::class);
        // $this->call(SkillsTableSeeder::class);
        // $this->call(TeamsTableSeeder::class);
        // $this->call(SkillUsersTableSeeder::class
        // $this->call(TeamUsersTableSeeder::class);
        // $this->call(PositionTeamsTableSeeder::class);  
        // $this->call(ProjectTeamsTableSeeder::class);     
        // $this->call(ActivitiesTableSeeder::class);          
    }
}
