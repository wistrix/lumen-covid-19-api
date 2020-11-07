<?php

namespace App\Imports;

use App\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class CountriesImport implements ToCollection
{
    /**
     * @var Collection
     */
    protected $countries;

    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $this->setCountries($collection);

        $this->countries->each(function($country) {
            Country::updateOrCreate([
                'name' => $country[7],
            ], [
                'name' => $country[7],
                'code' => $country[2],
                'latitude' => $country[8] ?? 0,
                'longitude' => $country[9] ?? 0,
            ]);
        });
    }

    /**
     * @param Collection $collection
     */
    private function setCountries(Collection $collection)
    {
        // only interested in top level country meta data
        $this->countries = $collection->slice(1)->reject(function($country) {
            return $country[6];
        });
    }
}
