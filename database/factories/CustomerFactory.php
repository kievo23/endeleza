<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        //
        'customer_account_msisdn' => $faker->e164PhoneNumber(),
        'person_id' => $faker->numberBetween(1,20),
        'account_limit' => $faker->numberBetween(3000,50000),
        'active' => 1
    ];
});
