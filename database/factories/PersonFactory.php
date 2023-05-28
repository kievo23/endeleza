<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Person;
use Faker\Generator as Faker;

$factory->define(Person::class, function (Faker $faker) {
    return [
        //
        'first_name' => $faker->name(),
        'id_number' => $faker->numberBetween(10000000,42999999),
        'primary_msisdn' => $faker->e164PhoneNumber()
    ];
});
