<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Projet;
use Faker\Generator as Faker;

$factory->define(Projet::class, function (Faker $faker) {
    return [
        'title' =>  $faker->sentence(3,true),
        'description' =>  $faker->sentence(6,true),
        'user_id'=> $faker->numberBetween(1,9)
    ];
});
