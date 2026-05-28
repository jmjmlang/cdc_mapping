<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'           => 'Admin',
                'password'       => bcrypt('admin1234'),
                'role'           => 'admin',
                'account_status' => 'approved',
            ]
        );

        // Citizen — John Michael Talbo
        User::updateOrCreate(
            ['email' => 'johnmichael.talbo@gmail.com'],
            [
                'name'           => 'John Michael Talbo',
                'password'       => bcrypt('citizen1234'),
                'role'           => 'citizen',
                'account_status' => 'approved',
                'gender'         => 'male',
                'birthdate'      => '2000-03-15',
                'age'            => 26,
            ]
        );

        // Citizen — Engiemar Balanay
        User::updateOrCreate(
            ['email' => 'engiemar.balanay@gmail.com'],
            [
                'name'           => 'Engiemar Balanay',
                'password'       => bcrypt('citizen1234'),
                'role'           => 'citizen',
                'account_status' => 'approved',
                'gender'         => 'male',
                'birthdate'      => '2000-07-22',
                'age'            => 25,
            ]
        );
    }
}
