<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'description' => $faker->paragraph(10)
    ];
});
