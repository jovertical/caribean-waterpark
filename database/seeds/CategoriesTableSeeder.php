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
            'name' => 'room',
            'description' => str_random(100),
        ]);

        \App\Category::create([
            'name' => 'cottage',
            'description' => str_random(100),
        ]);
    }
}
