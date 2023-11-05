<?php

namespace Database\Factories;

use App\Enums\RolesUsersEnum;
use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Media;
use App\Models\SeatType;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends Factory<Cinema>
 */
class CinemaFactory extends Factory
{
    public function definition(): array
    {
        $address = $this->faker
                ->city . ' ' . fake()
                ->streetAddress();

        return [
            'name' => $this->faker->unique()->colorName,
            'description' => $this->faker->paragraph,
            'address' => $address,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Cinema $cinema) {
            $mediaCount = rand(1, 3);

            for ($i = 0; $i < 3; $i++) {
                $roleValues = [RolesUsersEnum::CINEMA_MANAGER->value, RolesUsersEnum::CINEMA_ADMIN->value];
                $randomRoleValue = array_rand(array_flip($roleValues), 1);

                $user = User::query()
                    ->whereDoesntHave('cinemas')
                    ->whereDoesntHave('roles', function (Builder $query) {
                        $query->where('name', RolesUsersEnum::SUPER_ADMIN->value);
                    })
                    ->whereHas('roles', function (Builder $builder) use ($randomRoleValue) {
                        $builder->where('name', $randomRoleValue);
                    })
                    ->inRandomOrder()
                    ->first();

                if ($user !== null) {
                    $cinema->users()->attach($user);
                }
            }

            SeatType::factory()
                ->count(4)
                ->create(['cinema_id' => $cinema->id]);

            Hall::factory()
                ->count(rand(1, 5))
                ->create(['cinema_id' => $cinema->id]);

            for ($i = 0; $i < $mediaCount; $i++) {
                $cinema->medias()->create([
                    'path' => $this->faker->filePath(),
                ]);
            }
        });
    }
}
