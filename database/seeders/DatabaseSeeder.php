<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Booking;
use App\Models\Cinema;
use App\Models\Genre;
use App\Models\Hall;
use App\Models\Movie;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(5)->create();
        Cinema::factory(3)->create();
        Genre::factory(20)->create();
        Movie::factory(30)->create();

        $movies = Movie::all();
        $genres = Genre::all();

        Movie::all()->each(function ($movie) use ($genres) {
            $movie->genres()->attach(
                $genres->random(rand(1, 3))->pluck('id')->toArray()
            );
        });

        $halls = Hall::all();

        foreach ($movies as $movie) {
            foreach ($halls as $hall) {
                Screening::factory()->create([
                    'movie_id' => $movie->id,
                    'hall_id' => $hall->id,
                    'price' => fake()->randomFloat(2, 10, 20),
                    'start_at' => fake()->dateTimeBetween('now','+1 years'),
                ]);
            }
        }

        Booking::factory(30)->create();
    }
}
