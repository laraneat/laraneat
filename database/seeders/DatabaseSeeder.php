<?php

namespace Database\Seeders;

use Laraneat\Core\Loaders\SeederLoaderTrait;
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
        $this->runLoadingSeeders();
    }
}
