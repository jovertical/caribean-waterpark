<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['accomodation', 'miscellaneous']),
        'name' => $faker->name,
        'description' => $faker->paragraph(10)
    ];
});
