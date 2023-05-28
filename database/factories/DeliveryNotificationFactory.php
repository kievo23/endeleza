<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\DeliveryNotification;
use Faker\Generator as Faker;

$factory->define(DeliveryNotification::class, function (Faker $faker) {
    return [
        //
        'customer_stall_id' => $faker->numberBetween(1,20), 
        'receipt_number' => $faker->word(),
        'amount' => $faker->numberBetween(1000,100000),
        'customer_id' => $faker->numberBetween(1, 20),
        'delivery_date' => $faker->dateTime('now','Africa/Nairobi'),
        'deleted' => null
    ];
});
