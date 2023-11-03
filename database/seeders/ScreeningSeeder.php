<?php

namespace Database\Seeders;

use App\Models\Hall;
use App\Models\Movie;
use App\Models\Screening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $movies = Movie::all();
        $halls = Hall::all();

        foreach ($movies as $movie) {
            foreach ($halls as $hall) {
                Screening::create([
                    'movie_id' => $movie->id,
                    'hall_id' => $hall->id,
                    'price' => fake()->randomFloat(2, 10, 20),
                    'start_at' => fake()->dateTimeBetween('now','+1 years'),
                ]);
            }
        }
    }
}
