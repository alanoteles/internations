<?php

use Illuminate\Database\Seeder;
use App\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Group::truncate();

        // Creates 3 test groups. Not using faker Factory.
        for ($i = 1; $i < 4; $i++) {
            Group::create([
                'name' => 'Group ' . $i,
            ]);
        }

    }
}
