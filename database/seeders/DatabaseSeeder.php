<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
        ]);

        Cinema::factory(rand(2, 5))->create();
        Genre::factory(20)->create();
        Movie::factory(30)->create();

        $this->call([
            ScreeningSeeder::class,
            UserSeeder::class,
        ]);

        Booking::factory(10)->create();
    }
}
