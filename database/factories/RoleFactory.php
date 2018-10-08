<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Roles::class, function (Faker $faker) {
    return [
        'id' => uniqid("", true),
        'name' => $faker->name,
        'creator_id'=>uniqid("", true),
    ];
});
