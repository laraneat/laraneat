<?php

namespace Database\Seeders;

use App\Ship\Abstracts\Seeders\Seeder;
use Laraneat\Modules\Traits\SeederLoaderTrait;

class SeedDeploymentData extends Seeder
{
    use SeederLoaderTrait;

    /**
     * Note: This seeder is not loaded automatically by Laraneat
     * This is a special seeder which can be called by "laraneat:seed:deploy" command
     * It is useful for seeding data for initial deployment.
     */
    public function run(): void
    {
        // run module seeders from `/Seeders` and `/Seeders/Deployment` directories
        $this->runSeedersFromModules(['/', '/Deployment']);
    }
}
