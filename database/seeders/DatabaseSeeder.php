<?php

namespace Database\Seeders;

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
        $this->runSeedersFromModules();
    }
}
