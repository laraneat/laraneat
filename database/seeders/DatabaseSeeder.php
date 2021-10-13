<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\App;
use Illuminate\Database\Seeder;
use Laraneat\Modules\Traits\SeederLoaderTrait;

class DatabaseSeeder extends Seeder
{
    use SeederLoaderTrait;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        if (App::isProduction()) {
            $this->call(SeedDeploymentData::class);
            return;
        }

        if (App::runningUnitTests()) {
            $this->call(SeedTestingData::class);
            return;
        }

        // run common module seeders from `/Seeders` directory
        $this->runSeedersFromModules();
    }
}
