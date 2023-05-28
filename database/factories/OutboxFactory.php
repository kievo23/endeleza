<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Outbox;
use Faker\Generator as Faker;

$factory->define(Outbox::class, function (Faker $faker) {
    return [
        //
        'phone' => $faker->phoneNumber,
        'text' => $faker->sentence(),
        'cost' => 0.9,
        'status' => 1
    ];
});
