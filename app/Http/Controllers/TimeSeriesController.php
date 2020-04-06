<?php

namespace App\Http\Controllers;

use App\Http\Resources\TimeSeriesCollection;
use App\TimeSeries;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class TimeSeriesController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return Cache::rememberForever('timeSeries', function() {
            $timeSeries = TimeSeries::ordered()->cursor();

            return (TimeSeriesCollection::make($timeSeries))->toArray(null);
        });
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function latest()
    {
        return Cache::rememberForever('timeSeries:latest', function() {
            $timeSeries = TimeSeries::where('date', function ($query) {
                $query->selectRaw('MAX(t2.date)')
                    ->from('time_series', 't2')
                    ->whereColumn('t2.country_id', 'country_id')
                    ->limit(1);
            })->cursor();

            return (TimeSeriesCollection::make($timeSeries))->toArray(null);
        });
    }
}
