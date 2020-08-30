<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sentence;
use App\Models\Favorite;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Favorite::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'sentence_id' => function(){
            return factory(Sentence::class)->create()->id;
        },
    ];
});
