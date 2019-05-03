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
        // Runs Groups seeder before users, so we have Group ID to the pivot table on Users seed.
        $this->call(GroupsTableSeeder::class);
        $this->call(UsersTableSeeder::class);

    }
}
