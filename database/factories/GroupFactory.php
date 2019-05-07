<?php

use Faker\Generator as Faker;
//use App\Group;

$factory->define(App\Group::class, function (Faker $faker) {
    return [
        'name' => 'Group ' . $faker->name,
    ];
});
