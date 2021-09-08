<?php

namespace App\Ship\Abstracts\Jobs;

use Laraneat\Core\Abstracts\Jobs\Job as AbstractJob;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class Job extends AbstractJob implements ShouldQueue
{
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "onQueue" and "delay" queue helper methods.
    |
    */

}
