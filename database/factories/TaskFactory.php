<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'id' => (rand(9,999999999)+time()) * rand(0,999),
        'user_id' => factory(App\User::class),
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'observation' => $faker->sentence,
        'status' => 'To Do',
    ];
});
