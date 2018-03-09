<?php

use agoalofalife\Reports\Models\Report;
use Faker\Generator as Faker;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'class_name' => $faker->name,
        'status' => $faker->randomElement([
            Report::STATUS_COMPLETED,
            Report::STATUS_NEW,
            Report::STATUS_ERROR,
            Report::STATUS_PROCESS,
            Report::STATUS_WORKER
        ]),
        'is_completed' => $faker->boolean,
        'pid' => $faker->randomDigit,
    ];
});