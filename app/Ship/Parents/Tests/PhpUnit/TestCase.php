<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use Laraneat\Core\Abstracts\Tests\PhpUnit\TestCase as AbstractTestCase;
use Faker\Generator;
use Illuminate\Contracts\Console\Kernel as LaraneatConsoleKernel;
use Illuminate\Foundation\Application;

abstract class TestCase extends AbstractTestCase
{
    protected Generator $faker;

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
    public function createApplication()
    {
        $this->baseUrl = env('API_FULL_URL'); // this reads the value from `phpunit.xml` during testing

        // override the default subDomain of the base URL when subDomain property is declared inside a test
        $this->overrideSubDomain();

        $app = require __DIR__ . '/../../../../../bootstrap/app.php';

        $app->make(LaraneatConsoleKernel::class)->bootstrap();

        // create instance of faker and make it available in all tests
        $this->faker = $app->make(Generator::class);

        return $app;
    }

    protected function getCountOnPage(int $page, int $total, ?int $perPage = null): int
    {
        $perPage = $perPage ?? config('json-api-paginate.default_size');
        $lastPage = (int) ceil($total / $perPage);

        if ($page === $lastPage) {
            return $total - ($page - 1) * $perPage;
        }
        if ($page > $lastPage) {
            return 0;
        }

        return $perPage;
    }
}
