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
    ->apiResource('orders', 'Api\OrderController')
    ->except(['store']);

app('router')
    ->apiResource('products', 'Api\ProductController')
    ->only(['index','update']);

app('router')
    ->apiResource('partners', 'Api\PartnerController')
    ->only(['index']);

