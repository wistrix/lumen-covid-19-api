<?php

namespace App\Console\Commands;

use App\Imports\CountriesImport;
use Exception;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class CountriesImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'covid19:countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the countries data.';

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
        Excel::import(new CountriesImport, storage_path('app/countries.csv'));
    }
}
