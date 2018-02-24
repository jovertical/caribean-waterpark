<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create([
            'type' => 'accomodation',
            'name' => 'room',
            'description' => str_random(100),
        ]);

        \App\Category::create([
            'type' => 'accomodation',
            'name' => 'cottage',
            'description' => str_random(100),
        ]);

        \App\Category::create([
            'type' => 'miscellaneous',
            'name' => 'services',
            'description' => str_random(100),
        ]);
    }
}
