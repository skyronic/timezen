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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;
    $start_time = 12 + $faker->numberBetween(0, 4);
    $ideal_start = $start_time + $faker->numberBetween(0, 4);

    $ideal_end = 30 + $faker->numberBetween(0, 6);
    $end_time = $ideal_end + $faker->numberBetween(0, 4);

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'timezone' => $faker->timezone,
        'day_start' => $start_time,
        'ideal_start' => $ideal_start,
        'ideal_end' => $ideal_end,
        'day_end' => $end_time,

        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});
