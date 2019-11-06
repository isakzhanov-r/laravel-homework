<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Vendor;
use Faker\Generator as Faker;

$factory->define(Vendor::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->companyEmail,
        'name'  => $faker->unique()->company,
    ];
});
