<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => 'jovert123',
            'email' => 'jovert@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser'
        ]);

        \App\User::create([
            'name' => 'john123',
            'email' => 'john@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'user'
        ]);
    }
}
