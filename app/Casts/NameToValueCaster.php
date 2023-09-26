<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class NameToValueCaster implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Return the 'name' attribute value from the attributes array, if it exists.
        return $attributes['name'] ?? null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        // Set the 'name' attribute to the provided value.
        $attributes['name'] = $value;
        // If needed, remove the original 'value' attribute.
        unset($attributes[$key]);

        return $attributes;
    }
}
