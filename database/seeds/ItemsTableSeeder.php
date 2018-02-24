<?php

use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Item::create([
            'category_id' => 1,
            'name' => 'princess',
            'description' => str_random(100),
            'price' => 2000.00,
            'quantity' => 5
        ]);

        \App\Item::create([
            'category_id' => 1,
            'name' => 'prince',
            'description' => str_random(100),
            'price' => 2000.00,
            'quantity' => 5
        ]);

        \App\Item::create([
            'category_id' => 1,
            'name' => 'hotel',
            'description' => str_random(100),
            'price' => 3000.00,
            'quantity' => 5
        ]);

        \App\Item::create([
            'category_id' => 1,
            'name' => 'bahay kubo',
            'description' => str_random(100),
            'price' => 1500.00,
            'quantity' => 10
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'pirates',
            'description' => str_random(100),
            'price' => 1500.00,
            'quantity' => 10
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'modern',
            'description' => str_random(100),
            'price' => 700.00,
            'quantity' => 15
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'family',
            'description' => str_random(100),
            'price' => 2000.00,
            'quantity' => 15
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'coconut',
            'description' => str_random(100),
            'price' => 500.00,
            'quantity' => 25
        ]);
    }
}
