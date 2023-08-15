<?php

namespace Tests\Casts\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use Num\Casts\NumFloat;
use Num\Casts\NumInt;

class Model extends BaseModel
{
    protected $guarded = [];

    protected $fillable = [
        'integer',
        'float',
    ];

    protected $casts = [
        'integer' => NumInt::class,
        'float'   => NumFloat::class,
    ];
}
