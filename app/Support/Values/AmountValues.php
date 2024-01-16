<?php

namespace App\Support\Values;

use Illuminate\Contracts\Database\Eloquent\Castable;

class AmountValues implements Castable
{
    private readonly string $value;

    public function __construct(string $value)
    {
        if (!is_numeric($value)) {
            throw new \InvalidArgumentException(
                'The value must be numeric' . $value,
            );
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param array $arguments
     * @return string
     */
    public static function castUsing(array $arguments): string
    {
        return AmountCast::class;
    }

    public function __toString()
    {
        return $this->getValue();
    }
}
