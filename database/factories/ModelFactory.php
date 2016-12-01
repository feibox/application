<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    $rank = rand(1, 5);
    $study_level = ($rank > 3) ? 2 : 1;
    $user_name = $faker->unique()->userName;
    $title_prefix = ($study_level === 2) ? 'Bc.' : null;

    if ($study_level == 2) {
        $study_information = 'FEEIT I-API den [term 3, year '.($rank - 3).']';
    } else {
        $study_information = 'FEEIT B-API den [term 3, year '.$rank.']';
    }

    return [
        'ais_id' => $faker->unique()->numberBetween(1000, 100000),
        'rank' => $rank,
        'study_level' => $study_level,
        'email' => $user_name.'@stuba.sk',
        'user_name' => $user_name,
        'first_name' => $faker->firstName,
        'middle_name' => $faker->firstName,
        'last_name' => $faker->unique()->lastName,
        'title_prefix' => $title_prefix,
        'title_suffix' => null,
        'study_information' => $study_information,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(30),
        'is_admin' => false,
        'is_valid' => true,
    ];
});

$factory->defineAs(App\User::class, 'invalid', function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->userName.'@stuba.sk',
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(30),
    ];
});
