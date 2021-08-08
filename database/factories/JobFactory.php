<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Job::class, function (Faker $faker) {


    return [
        'description' => $faker->sentence,
        'created_at' => $faker->dateTime($max = 'now', $timezone = null),
        'created_by' => 1,
        'status' => 'active',
        'is_deleted' => 0,
        'business_id' => 1,
        'job_title_id' => 1,
        'salary' => $faker->numberBetween(10000,20000),
        'min_experience' => $faker->numberBetween(12,100),
        'starting_from' =>  '2018-10-25 08:00:00',
        'ending_at' =>  '2018-10-30 08:00:00',
        'payment_status' =>  'done',
        'lat' =>  $faker->latitude($min = -90, $max = 90),
        'lng' =>  $faker->longitude($min = -180, $max = 180),
        'address1' =>  $faker->streetAddress,
        'city' =>  $faker->city,
        'state_id' =>  1,
        'country_id' =>  1,
        'zip_code' => $faker->postcode,


    ];
});

