<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LoanAccount;
use Faker\Generator as Faker;

$factory->define(LoanAccount::class, function (Faker $faker) {
    return [
        //
        'customer_account_id' => $faker->numberBetween(1,20),
        'delivery_id' => $faker->numberBetween(1,20),
        'principal_amount' => $faker->numberBetween(2000,9000),
        'interest_charged' => $faker->numberBetween(0,100),
        'loan_amount' => $faker->numberBetween(2000,9000),
        'loan_balance' => $faker->numberBetween(2000,9000),
        'loan_penalty' => $faker->numberBetween(0,400),
        'loan_status' => 1,
    ];
});
