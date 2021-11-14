<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Address;
use App\Models\Country;
use App\Models\User;
use Faker\Generator as Faker;
use Faker\Provider\en_US\Address as En_USAddress;

$factory->define(Address::class, function (Faker $faker) {
    $faker->addProvider(new En_USAddress($faker));
    return [
        'alias' => $faker->randomElement(['home', 'office']) . $faker->unique()->randomNumber(4),
        'address_1' => $faker->address,
        'address_2' => $faker->secondaryAddress,
        'city' => $faker->city,
        'zip' => $faker->postcode,
        'phone' => $faker->e164PhoneNumber,
        'country_id' => 226,
        'user_id' => factory(User::class),
    ];
});
