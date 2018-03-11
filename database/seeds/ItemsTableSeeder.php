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
        $description =  str_shuffle(
                            'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur provident fuga eos exercitationem cumque nemo blanditiis illum harum ut tempora, nam odit doloribus, culpa labore dicta reiciendis minus quod cum!'
                        );

        \App\Item::create([
            'category_id' => 1,
            'name' => 'princess',
            'description' => $description,
            'price' => 2000.00,
            'quantity' => 5
        ]);

        \App\Item::create([
            'category_id' => 1,
            'name' => 'prince',
            'description' => $description,
            'price' => 2000.00,
            'quantity' => 5
        ]);

        \App\Item::create([
            'category_id' => 1,
            'name' => 'hotel',
            'description' => $description,
            'price' => 3000.00,
            'quantity' => 5
        ]);

        \App\Item::create([
            'category_id' => 1,
            'name' => 'bahay kubo',
            'description' => $description,
            'price' => 1500.00,
            'quantity' => 10
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'pirates',
            'description' => $description,
            'price' => 1500.00,
            'quantity' => 10
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'modern',
            'description' => $description,
            'price' => 700.00,
            'quantity' => 15
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'family',
            'description' => $description,
            'price' => 2000.00,
            'quantity' => 15
        ]);

        \App\Item::create([
            'category_id' => 2,
            'name' => 'coconut',
            'description' => $description,
            'price' => 500.00,
            'quantity' => 25
        ]);
    }
}
