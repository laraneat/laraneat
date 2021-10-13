<?php

namespace Database\Seeders;

use App\Ship\Seeders\SeedDeploymentData;
use App\Ship\Seeders\SeedTestingData;
use Illuminate\Support\Facades\App;
use Laraneat\Modules\Traits\SeederLoaderTrait;
use Illuminate\Database\Seeder;

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
    }
}
