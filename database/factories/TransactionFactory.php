<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Transaction;
use Faker\Generator as Faker;

$factory->define(Transaction::class, function (Faker $faker) {
    return [
        //
        'customer_id' => $faker->numberBetween(1,10),
        'payer_names' => $faker->name(),
        'gl_account_id' => null,
        'loan_account_id' => $faker->numberBetween(1,30),
        'msisdn' => $faker->e164PhoneNumber(),
        'paid_by' => $faker->name(),
        'transaction_reference' => $faker->randomLetter(),
        'transaction_amount' => $faker->numberBetween(1000,6000),
        'debit' => 0,
        'credit' => 0,
        'gl_debit' => 0,
        'gl_credit' => 0,
        'transaction_time' => $faker->dateTime("now",null),
        'transaction_status' => 0,
        'transaction_type' => $faker->creditCardType()
    ];
});
