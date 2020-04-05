<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function(Request $request) use ($router) {
    return [
        'name' => env('APP_NAME'),
        'host' => $request->getHost()
    ];
});

$router->get('/countries', 'CountryController@index');
$router->get('/countries/{id:[0-9]+}', 'CountryController@show');
$router->get('/countries/{id:[0-9]+}/timeseries', 'CountryController@timeSeries');
$router->get('/countries/{id:[0-9]+}/latest', 'CountryController@latestTimeSeries');

$router->get('/timeseries', 'TimeSeriesController@index');
$router->get('/timeseries/latest', 'TimeSeriesController@latest');
