<?php

namespace Num\Casts;

use Num\Num;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class NumInt implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): ?int
    {
        if ($value === null) {
            return null;
        }

        if (is_numeric($value)) {
            return (int) $value;
        }

        if (is_string($value)) {
            return Num::int($value);
        }

        throw new \InvalidArgumentException("The value must be either an integer or a string.");
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): array
    {
        if ($value === null) {
            return [$key => $value];
        }

        if (is_numeric($value)) {
            return [$key => (int) $value];
        }

        if (is_string($value)) {
            return Num::int($value);
        }

        throw new \InvalidArgumentException("The value must be either an integer or a string.");
    }
}
