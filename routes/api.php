<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

app('router')
    ->get('weather/{vendor}', 'Api\WeatherController');

app('router')
    ->get('orders/grouped', 'Api\OrderController@grouped')
    ->name('orders.grouped');

app('router')
    ->get('orders/grouped/count', 'Api\OrderController@groupedCount')
    ->name('orders.grouped.count');

app('router')
    ->apiResource('orders', 'Api\OrderController')
    ->except(['store']);

