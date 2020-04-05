<?php

namespace App\Console\Commands;

use Exception;
use App\Imports\TimeSeriesImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class TimeSeriesImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid19:timeseries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the time series data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws Exception
     */
    public function handle()
    {
        Excel::import(new TimeSeriesImport('confirmed'), storage_path('app/confirmed.csv'));
        Excel::import(new TimeSeriesImport('deaths'), storage_path('app/deaths.csv'));
        Excel::import(new TimeSeriesImport('recovered'), storage_path('app/recovered.csv'));

        // Flush cache
        Cache::flush();
    }
}
