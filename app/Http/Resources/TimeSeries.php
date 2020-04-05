<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimeSeries extends JsonResource
{
    /**
     * @param Request $request
     * @return array|mixed
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'country_id' => $this->country_id,
            'date'       => $this->date,
            'confirmed'  => $this->confirmed,
            'deaths'     => $this->deaths,
            'recovered'  => $this->recovered
        ];
    }
}
