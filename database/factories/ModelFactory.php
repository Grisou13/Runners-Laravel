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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
        "first_name"=>$faker->name,
        "last_name"=>$faker->lastName,
        "shortname"=>str_random(4),
        "sex"=>$faker->boolean,
        "phone"=>$faker->phoneNumber,
        "qr_code"=>str_random(255)
    ];
});

$factory->define(App\Car::class, function (Faker\Generator $faker){
    return [
        "licence_plates"=>"VD ".$faker->numberBetween(1000000,200000),
        "brand"=>$faker->company,
        "model"=>$faker->word,
        "color"=>$faker->colorName,
        "seats"=>$faker->numberBetween(3,7),
        "comment"=>"",
        "shortname"=>$faker->word,

    ];
});
$factory->define(App\CarType::class, function (Faker\Generator $faker){
    return [
        "type"=>$faker->word,
        "description"=>$faker->text
    ];
});
$factory->define(App\Run::class, function (Faker\Generator $faker){
    return [
        "start_date"=>$faker->dateTimeBetween("now","+13 days"),
        "end_date"=>$faker->dateTimeBetween("+13 days","+15 days"),
        "start_site"=>$faker->company,
        "arrival_site"=>"geneve aeroport",
        "flight_num"=>$faker->numberBetween(0,400),
        "note"=>$faker->text
    ];
});
$factory->define(App\Group::class, function (Faker\Generator $faker){
    return [
        "active"=>$faker->boolean
    ];
});