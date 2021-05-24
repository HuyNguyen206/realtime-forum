<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reply;
use Faker\Generator as Faker;

$factory->define(Reply::class, function (Faker $faker) {
    return [
        //
        'body' => $faker->text,
        'question_id' => \App\Question::all()->random(),
        'user_id' => \App\User::all()->random()
    ];
});
