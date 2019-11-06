<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weather;

    public function __construct(WeatherService $weather_service)
    {
        $this->weather = $weather_service;
    }

    public function __invoke(string $vendor)
    {

        $data = $this->weather
            ->vendor($vendor)
            ->get();

        return response()->json($data);
    }
}
