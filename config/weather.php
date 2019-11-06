<?php

return [
    'yandex'   => [
        'url'     => env('WEATHER_API_URL', 'https://api.weather.yandex.ru/v1/forecast'),
        'headers' => [
            'Accept'           => 'application/json',
            'X-Yandex-API-Key' => env('WEATHER_API_KEY', '63775b46-4052-466e-b381-11a9122e48b0'),
        ],
        'params'  => [
            'lon'   => 34.363407,
            'lat'   => 53.243562,
            'lang'  => 'ru_RU',
            'hours' => false,
            'extra' => false,
        ],
    ],
    'gismeteo' => [
        'url'     => env('WEATHER_API_URL', 'https://api.gismeteo.net/v2/weather/current'),
        'headers' => [
            'Accept'           => 'application/json',
            'X-Gismeteo-Token' => env('WEATHER_API_KEY', '56b30cb255.3443075'),
        ],
        'params'  => [
            'longitude' => 34.363407,
            'latitude'  => 53.243562,
        ],
    ],

    'openweathermap' => [
        'url'     => env('WEATHER_API_URL', 'https://api.openweathermap.org/data/2.5/weather'),
        'headers' => [
            'Accept' => 'application/json',
        ],
        'params'  => [
            'lon'   => 34.363407,
            'lat'   => 53.243562,
            'appid' => '69ea6245422426a070ec7a5c5ccd9d87',
        ],
    ],
];
