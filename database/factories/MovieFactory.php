<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->sentence(3);

        return [
            'name' => $name,
            'description' => $this->faker->paragraph(3),
            'session_duration' => $this->faker->time('H:i', 14400),
            'date_start' => $this->faker->dateTimeBetween('now','+7 months'),
            'rating' => rand(10,100)/10,
            'age_limit' => rand(6, 21),
            'slug' => Str::slug($name),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Movie $movie) {
            $mediaCount = rand(1, 3);

            for ($i = 0; $i < $mediaCount; $i++) {
                $movie->medias()->create([
                    'path' => $this->faker->filePath(),
                ]);
            }

            $movie->genres()->attach(
                Genre::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });
    }
}
