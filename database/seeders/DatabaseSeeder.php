<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Booking;
use App\Models\Theatre;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\User;
use App\Services\Currencies\Models\Currency;
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
            ModeratorSeeder::class,
        ]);

        User::factory(100)->create();
        Theatre::factory(rand(3, 5))->create();
        Genre::factory(20)->create();
        Movie::factory(30)->create();

        $this->call([
            ScreeningSeeder::class,
        ]);

        Currency::factory(2)->create();
        Booking::factory(1000)->create();
    }
}
