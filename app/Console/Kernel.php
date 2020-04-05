<?php

namespace App\Console;

use App\Console\Commands\CountriesImportCommand;
use App\Console\Commands\TimeSeriesFetchCommand;
use App\Console\Commands\TimeSeriesImportCommand;
use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        TimeSeriesFetchCommand::class,
        CountriesImportCommand::class,
        TimeSeriesImportCommand::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('covid19:fetch')->cron('0 3 * * *')->then(function() {
            $this->call('covid19:countries');
            $this->call('covid19:timeseries');
        });
    }
}
