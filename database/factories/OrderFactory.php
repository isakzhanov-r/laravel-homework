<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    $createdAt = \Carbon\Carbon::now()->subDays(rand(0, 4));
    $status    = [0, 10, 20];

    return [
        'status'       => $status[rand(0, 2)],
        'client_email' => $faker->safeEmail,
        'partner_id'   => $faker->numberBetween(1, 20),
        'delivery_at'  => $createdAt->copy()->addHours(rand(6, 50)),
        'created_at'   => $createdAt,
        'updated_at'   => $createdAt->copy()->addHours(rand(1, 5)),
    ];
});
