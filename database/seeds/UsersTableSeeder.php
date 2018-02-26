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
            'slug' => str_random(10),
            'name' => 'jovert123',
            'email' => 'jobert.lota18@gmail.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',

            'first_name' => 'jovert',
            'middle_name' => 'lota',
            'last_name' => 'palonpon',
            'birthdate' => '1998-05-18',
            'gender' => 'male',
            'address' => 'marungko, angat, bulacan',
            'phone_number' => '09356876995'
        ]);

        \App\User::create([
            'slug' => str_random(10),
            'name' => 'chito123',
            'email' => 'chito@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',
        ]);

        \App\User::create([
            'slug' => str_random(10),
            'name' => 'arnie123',
            'email' => 'arnie@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',
        ]);

        \App\User::create([
            'slug' => str_random(10),
            'name' => 'kennent123',
            'email' => 'kennent@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',
        ]);

        \App\User::create([
            'slug' => str_random(10),
            'name' => 'aldrin',
            'email' => 'aldrin@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'user'
        ]);

        \App\User::create([
            'slug' => str_random(10),
            'name' => 'andrew',
            'email' => 'andrew@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'user'
        ]);
    }
}
