<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Book;
use App\Models\Sentence;
use Faker\Generator as Faker;

$factory->define(Sentence::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create()->id;
        },
        'book_id' => function(){
            return factory(Book::class)->create()->id;
        },
        'text_1' => $faker->text,
        'text_2' => $faker->text,
        'text_3' => $faker->text,
        'status' => 0,
    ];
});
