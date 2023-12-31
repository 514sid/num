<?php

namespace Num\Casts;

use Num\Num;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class NumInt implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     * @return array<string, mixed>
     */
    public function get($model, string $key, mixed $value, array $attributes): ?int
    {
        if ($value === null) {
            return null;
        }

        return Num::int($value);
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

        return [$key => Num::int($value)];
    }
}
