<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,

            // jalankan seeder kebun manual setelah melengkapi data diri user
            // php artisan db:seed --class=KebunSeeder
            // KebunSeeder::class,
        ]);
    }
}
