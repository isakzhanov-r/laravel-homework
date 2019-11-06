<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name'      => 'Product_' . $faker->unique()->numberBetween(0, 2000),
        'price'     => $faker->numberBetween(100, 1000),
        'vendor_id' => $faker->numberBetween(1, 10),
    ];
});
