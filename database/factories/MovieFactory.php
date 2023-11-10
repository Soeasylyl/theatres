<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array The model's default state.
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->sentence(3);
        $slug = Str::slug($name);

        return [
            'name' => $name,
            'description' => $this->faker->paragraph(3),
            'session_duration' => $this->faker->time('H:i', 14400),
            'date_start' => $this->faker->dateTimeBetween('now','+7 months'),
            'rating' => rand(10,100)/10,
            'age_limit' => rand(6, 21),
            'slug' => $slug,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return static The configured model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Movie $movie) {
            $mediaCount = rand(2, 5);

            for ($i = 0; $i < $mediaCount; $i++) {
                $collection = $i ===0 ? 'poster' : 'frames';
                $movie->medias()->create([
                    'path' => $this->faker->imageUrl(),
                    'collection' => $collection,
                ]);
            }

            $movie->genres()->attach(
                Genre::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });
    }
}
