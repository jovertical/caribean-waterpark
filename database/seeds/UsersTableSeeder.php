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
            'email' => 'jobert.lota18@gmail.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser'
        ]);

        \App\User::create([
            'name' => 'john123',
            'email' => 'j.palonpon.ipp@gmail.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'user'
        ]);
    }
}
