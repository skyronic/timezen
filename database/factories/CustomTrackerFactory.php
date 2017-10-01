<?php

use Faker\Generator as Faker;

$factory->define(App\CustomTracker::class, function (Faker $faker) {
    $start_time = 12 + $faker->numberBetween(0, 4);
    $ideal_start = $start_time + $faker->numberBetween(0, 4);

    $ideal_end = 30 + $faker->numberBetween(0, 6);
    $end_time = $ideal_end + $faker->numberBetween(0, 4);

    return [
        'name' => "(custom) ".$faker->firstName,
        'timezone' => $faker->timezone,
        'day_start' => $start_time,
        'ideal_start' => $ideal_start,
        'ideal_end' => $ideal_end,
        'day_end' => $end_time,
    ];
});
