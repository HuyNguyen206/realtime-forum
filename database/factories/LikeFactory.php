<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        //
        'user_id' => \App\User::all()->random(),
        'reply_id' => \App\Reply::all()->random()
    ];
});
