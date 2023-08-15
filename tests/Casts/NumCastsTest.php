<?php

namespace Num\Tests;

use Tests\Casts\TestCase;
use Tests\Casts\Models\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NumCastsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    public function testNumFloatCasts()
    {
        $model = new Model([
            'float' => 123,
        ]);

        $this->assertSame(123.0, $model->float);

        $model = new Model([
            'float' => null,
        ]);

        $this->assertSame(null, $model->float);

        DB::table('models')->insert([
            'float' => 123.45,
        ]);

        $model = Model::findOrFail(1);

        $this->assertSame(123.45, $model->float);

        $model = new Model([
            'float' => '123.45',
        ]);

        $this->assertSame(123.45, $model->float);
    }

    public function testNumIntCasts()
    {
        $model = new Model([
            'integer' => 123.45,
        ]);

        $this->assertSame(123, $model->integer);

        $model = new Model([
            'integer' => null,
        ]);

        $this->assertSame(null, $model->integer);

        DB::table('models')->insert([
            'integer' => 123,
        ]);

        $model = Model::findOrFail(1);

        $this->assertSame(123, $model->integer);

        $model = new Model([
            'integer' => '123.45',
        ]);

        $this->assertSame(123, $model->integer);
    }
}
