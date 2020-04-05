<?php

namespace App\Imports;

use App\Country;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class TimeSeriesImport implements ToCollection
{
    /**
     * @var Collection
     */
    protected $dates;

    /**
     * @var Collection
     */
    protected $countries;

    /**
     * @var string
     */
    protected $field;

    /**
     * TimeSeriesImport constructor.
     * @param string $field
     * @throws Exception
     */
    public function __construct(string $field)
    {
        $this->dates = collect();
        $this->countries = collect();
        $this->field = $field;

        HeadingRowFormatter::default('none');
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $this->setDates($collection->take(1));
        $this->setCountries($collection->slice(1));

        $this->countries->each(function(Collection $dates, $name) {
            // find a country, if for some reason it doesnt exist, create it as fallback
            $country = Country::firstOrCreate([
                'name' => $name,
            ]);

            $dates->each(function($value, $date) use ($country) {
                $country->timeSeries()->updateOrCreate([
                    'date' => $date,
                ], [
                    'date' => $date,
                    $this->field => $value,
                ]);
            });
        });
    }

    /**
     * @param Collection $collection
     */
    private function setCountries(Collection $collection)
    {
        // group by country (column '1') and sum date keys
        $this->countries = $collection->groupBy('1')->map(function ($item) {
            return $this->dates->flatMap(function($date, $index) use ($item) {
                return [
                    $date => $item->sum($index)
                ];
            });
        });
    }

    /**
     * @param Collection $collection
     */
    private function setDates(Collection $collection)
    {
        // flatten array and slice first 4
        // map collection and create carbon instance from value and convert to mysql date
        $this->dates = $collection->flatten()->slice(4)->map(function($value) {
            return Carbon::createFromFormat('m/d/y', $value)->toDateString();
        });
    }
}
