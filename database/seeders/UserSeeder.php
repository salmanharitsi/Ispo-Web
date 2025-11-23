<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'Salman Al Haritsi',
                'email' => 'salmanalharitsi14@gmail.com',
                'password' => 'salman123',
                'role' => 'pekebun',
            ],
        ];

        foreach ($user as $value) {
            User::create([
                'name' => $value['name'],
                'email' => $value['email'],
                'password' => $value['password'],
                'role' => $value['role'],
            ]);
        }
    }
}
