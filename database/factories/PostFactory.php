<?php

use Faker\Generator as Faker;

$factory->define(App\Models\PostModel::class, function (Faker $faker) {
    return [
        'id'=> uniqid(null, true),
        'name' => $faker->name,
        'description' => $faker->name,
    ];
});
