<?php

namespace App\Traits;

use App\Enums\Description;
use Illuminate\Support\Str;
use ReflectionClassConstant;

trait GetsAttributes
{
    /**
     * Get the description for the specified enum value, if available.
     *
     * @param self $enum
     */
    public static function getDescription(self $enum): string
    {
        $ref = new ReflectionClassConstant(self::class, $enum->name);
        $classAttributes = $ref->getAttributes(Description::class);

        if (count($classAttributes) === 0) {
            return Str::headline($enum->value);
        }

        return $classAttributes[0]->newInstance()->description;
    }

    /**
     * Get the enum values as an array suitable for use in a select field.
     *
     * @return array<string,string>
     */
    public static function asSelectArray(): array
    {
        /** @var array<string,string> $values */
        $values = collect(self::cases())
            ->map(function ($enum) {
                return [
                    'name' => self::getDescription($enum),
                    'value' => $enum->value,
                ];
            })->toArray();

        return $values;
    }

    /**
     * Convert the enum values into an array.
     *
     * @return string[]
     */
    public static function toArray(): array
    {
        /** @var array<string,string> $values */
        $values = collect(self::cases())
            ->map(function ($enum) {
                return $enum->value;
            })->toArray();

        return $values;
    }
}
