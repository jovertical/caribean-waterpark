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
            'name' => 'chito123',
            'email' => 'chito@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',

            'first_name' => 'chito',
            'middle_name' => 'santiago',
            'last_name' => 'navea',
            'birthdate' => '1900-01-01',
            'gender' => 'male',
            'address' => 'sta. cruz, angat, bulacan',
            'phone_number' => '09123456789'
        ]);

        \App\User::create([
            'name' => 'arnie123',
            'email' => 'arnie@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',

            'first_name' => 'arnie',
            'middle_name' => 'botas',
            'last_name' => 'mariano',
            'birthdate' => '1900-01-01',
            'gender' => 'male',
            'address' => 'sta. cruz, angat, bulacan',
            'phone_number' => '09123456789'
        ]);

        \App\User::create([
            'name' => 'kennent123',
            'email' => 'kennent@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'superuser',

            'first_name' => 'kennent anthony',
            'middle_name' => 'santiago',
            'last_name' => 'mendoza',
            'birthdate' => '1900-01-01',
            'gender' => 'male',
            'address' => 'sta. cruz, angat, bulacan',
            'phone_number' => '09123456789'
        ]);

        \App\User::create([
            'name' => 'aldrin',
            'email' => 'aldrin@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'user',

            'first_name' => 'aldrin',
            'middle_name' => 'cruz',
            'last_name' => 'alindogan',
            'birthdate' => '1900-01-01',
            'gender' => 'male',
            'address' => 'guyong, sta. maria, bulacan',
            'phone_number' => '09123456789'
        ]);

        \App\User::create([
            'name' => 'andrew',
            'email' => 'andrew@example.com',
            'password' => bcrypt('secret'),
            'verified' => true,
            'type' => 'user',

            'first_name' => 'mark andrew',
            'middle_name' => 'lunar',
            'last_name' => 'lovendino',
            'birthdate' => '1900-01-01',
            'gender' => 'male',
            'address' => 'sta. cruz, angat, bulacan',
            'phone_number' => '09123456789'
        ]);
    }
}
