<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        //
        'company_name' => $faker->company,
        'contact_person' => $faker->name,
        'mobile' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'address' => $faker->address
    ];
});
