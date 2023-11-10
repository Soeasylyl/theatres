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
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            PermissionsSeeder::class,
            SuperAdminSeeder::class,
        ]);

        User::factory(100)->create();
        Cinema::factory(rand(2, 5))->create();
        Genre::factory(20)->create();
        Movie::factory(30)->create();

        $this->call([
            ScreeningSeeder::class,
        ]);

        Booking::factory(10)->create();
    }
}
