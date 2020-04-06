<?php

namespace App\Http\Controllers;

use App\Country;
use App\Http\Resources\Country as CountryResource;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\TimeSeries as TimeSeriesResource;
use App\Http\Resources\TimeSeriesCollection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class CountryController extends Controller
{
    /**
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return Cache::rememberForever('countries', function(){
            $countries = Country::ordered()->cursor();

            return (CountryCollection::make($countries))->toArray(null);
        });
    }

    /**
     * @param int $id
     * @return CountryResource
     */
    public function show(int $id)
    {
        return Cache::rememberForever('countries:' . $id, function() use ($id) {
            return CountryResource::make(Country::findOrFail($id));
        });
    }

    /**
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function timeSeries(int $id)
    {
        return Cache::rememberForever('countries:' . $id . ':timeSeries', function() use ($id) {
            $timeSeries = Country::findOrFail($id)
                ->timeSeries()
                ->ordered()
                ->cursor();

            return (TimeSeriesCollection::make($timeSeries))->toArray(null);
        });
    }

    /**
     * @param int $id
     * @return TimeSeriesResource
     */
    public function latestTimeSeries(int $id)
    {
        return Cache::rememberForever('countries:' . $id . ':latestTimeSeries', function() use ($id) {
            $timeSeries = Country::findOrFail($id)
                ->timeSeries()
                ->latest('date')
                ->limit(1)
                ->first();

            return TimeSeriesResource::make($timeSeries);
        });
    }
}
