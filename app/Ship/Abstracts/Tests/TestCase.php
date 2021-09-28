<?php

namespace App\Ship\Abstracts\Tests;

use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;
use Laraneat\Modules\Traits\TestsTraits\TestsAuthHelperTrait;
use Laraneat\Modules\Traits\TestsTraits\TestsModelHelperTrait;
use Laraneat\Modules\Traits\TestsTraits\TestsUrlHelperTrait;

abstract class TestCase extends LaravelTestCase
{
    use TestsAuthHelperTrait,
        TestsModelHelperTrait,
        TestsUrlHelperTrait,
        RefreshDatabase;

    protected Generator $faker;

    /**
     * Determine if the seed task should be run when refreshing the database.
     */
    protected bool $seed = true;

    /**
     * Setup the test environment, before each test.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Reset the test environment, after each test.
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Creates the application.
     *
     * @return Application
     */
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../../../../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        // create instance of faker and make it available in all tests
        $this->faker = $app->make(Generator::class);

        return $app;
    }
}
