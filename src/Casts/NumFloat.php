<?php

namespace Num\Casts;

use Num\Num;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class NumFloat implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get($model, string $key, mixed $value, array $attributes): ?float
    {
        if ($value === null) {
            return null;
        }

        return Num::float($value);
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set($model, string $key, mixed $value, array $attributes): array
    {
        if ($value === null) {
            return [$key => $value];
        }

        return [$key => Num::float($value)];
    }
}
