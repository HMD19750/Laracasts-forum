<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Thread;
use App\Channel;
use Faker\Generator as Faker;

$factory->define(Thread::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'channel_id' => factory(App\Channel::class),
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
