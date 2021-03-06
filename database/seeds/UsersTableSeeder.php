<?php

use Illuminate\Database\Seeder;
use App\Group;
use App\User;
use Illuminate\Support\Facades\Schema;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Schema::disableForeignKeyConstraints();
        User::truncate();

        // Creates an Admin user
        User::create([
            'name'      => 'Administrator',
            'email'     => 'admin@email.com',
            'password'  => Hash::make('admin'),
            'admin'     => true
        ]);

        // Creates a normal user
        $user = User::create([
                    'name'      => 'Normal User',
                    'email'     => 'normal@email.com',
                    'password'  => Hash::make('normal'),
                    'admin'     => false
                ]);

        // Gets the first record from the table
        $group = Group::first();

        // Associate Normal User to first group. Other groups has no users, yet.
        $group->users()->attach($user);

        // Creating more users to test pagination.
        $users = factory(App\User::class, 50)->create();

        Schema::enableForeignKeyConstraints();
    }
}
