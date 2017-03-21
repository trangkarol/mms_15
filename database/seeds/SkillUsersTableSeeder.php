<?php

use Illuminate\Database\Seeder;

class SkillUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\SkillUser::class, 10)->create();
    }
}
