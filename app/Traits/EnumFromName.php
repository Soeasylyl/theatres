<?php

namespace App\Traits;

use App\Enums\Description;
use Illuminate\Support\Str;
use ReflectionClassConstant;
use ReflectionEnum;
use ValueError;

trait EnumFromName
{
    /**
     * To mirror backed enums tryFrom - returns null on failed match.
     */
    public static function tryFromName(string $name): ?static
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }

        return null;
    }

    /**
     * To mirror backed enums from - throws ValueError on failed match.
     */
    public static function fromName(string $name): static
    {
        $case = self::tryFromName($name);
        if (! $case) {
            throw new ValueError($name.' is not a valid case for enum '.self::class);
        }

        return $case;
    }
}
