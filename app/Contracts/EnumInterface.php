<?php

namespace App\Contracts;

Interface EnumInterface
{
    public static function tryFromName(string $name): ?static;
    public static function fromName(string $name): static;
}
