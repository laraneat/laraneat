<?php

namespace App\Ship\Console\Commands\Laraneat;

use App\Ship\Abstracts\Console\Command;
use Illuminate\Support\Facades\Config;

class SeedTestingDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = "laraneat:seed:test";

    /**
     * The console command description.
     */
    protected $description = "Seed testing data.";

    public function handle(): int
    {
        $this->call('db:seed', [
            '--class' => Config::get('laraneat.seeders.testing')
        ]);

        $this->info('Testing Data Seeded Successfully.');

        return 0;
    }
}
