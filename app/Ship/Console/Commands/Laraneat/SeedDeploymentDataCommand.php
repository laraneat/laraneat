<?php

namespace App\Ship\Console\Commands\Laraneat;

use App\Ship\Abstracts\Console\Command;
use Illuminate\Support\Facades\Config;

class SeedDeploymentDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "laraneat:seed:deploy";

    /**
     * The console command description.
     */
    protected $description = "Seed data for initial deployment.";

    public function handle(): int
    {
        $this->call('db:seed', [
            '--class' => Config::get('laraneat.seeders.deployment')
        ]);

        $this->info('Deployment Data Seeded Successfully.');

        return self::SUCCESS;
    }
}
