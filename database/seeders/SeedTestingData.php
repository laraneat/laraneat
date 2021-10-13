<?php

namespace Database\Seeders;

use App\Ship\Abstracts\Seeders\Seeder;
use Laraneat\Modules\Traits\SeederLoaderTrait;

class SeedTestingData extends Seeder
{
    use SeederLoaderTrait;

    /**
     * Note: This seeder is not loaded automatically by Laraneat
     * This is a special seeder which can be called by "laraneat:seed:test" command
     * It is useful for seeding testing data.
     */
    public function run(): void
    {
        // run module seeders from `/Seeders` and `/Seeders/Testing` directories
        $this->runSeedersFromModules(['/', '/Testing']);
    }
}
