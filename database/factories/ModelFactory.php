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
        "firstname"=>$faker->name,
        "lastname"=>$faker->lastName,
        "name"=>$faker->unique()->name,
        "sex"=>$faker->boolean,
        "phone_number"=>$faker->phoneNumber,
        "accesstoken"=>str_random(255),
        "group_id"=>factory(\App\Group::class)->create()->id,
        "status"=>\App\Helpers\Status::getUserStatus("actif")
    ];
});

$factory->define(App\Car::class, function (Faker\Generator $faker){
    return [
        "plate_number"=>"VD ".$faker->numberBetween(1000000,200000),
        "brand"=>$faker->company,
        "model"=>$faker->word,
        "color"=>$faker->colorName,
        "nb_place"=>$faker->numberBetween(3,7),
        "car_type_id"=>function(){return factory(App\CarType::class)->create()->id;},
        "name"=>$faker->word,
        "status"=>\App\Helpers\Status::getCarStatus("actif")
    ];
});

$factory->define(App\CarType::class, function (Faker\Generator $faker){
    return [
        "type"=>$faker->unique()->word,
        "description"=>$faker->text
    ];
});
$factory->define(App\Waypoint::class, function(Faker\Generator $faker){
  $geo = str_replace(["\n","\r"],"",trim("{
                    \"address_components\": [
                    {
                    \"long_name\": \"Genève Aéroport\",
                    \"short_name\": \"Genève Aéroport\",
                    \"types\": [
                    \"airport\",
                    \"establishment\",
                    \"point_of_interest\"
                    ]
                    },
                    {
                    \"long_name\": \"21\",
                    \"short_name\": \"21\",
                    \"types\": [
                    \"street_number\"
                    ]
                    },
                    {
                    \"long_name\": \"Route de l'Aéroport\",
                    \"short_name\": \"Route de l'Aéroport\",
                    \"types\": [
                    \"route\"
                    ]
                    },
                    {
                    \"long_name\": \"Le Grand-Saconnex\",
                    \"short_name\": \"Le Grand-Saconnex\",
                    \"types\": [
                    \"locality\",
                    \"political\"
                    ]
                    },
                    {
                    \"long_name\": \"Genève\",
                    \"short_name\": \"Genève\",
                    \"types\": [
                    \"administrative_area_level_2\",
                    \"political\"
                    ]
                    },
                    {
                    \"long_name\": \"Genève\",
                    \"short_name\": \"GE\",
                    \"types\": [
                    \"administrative_area_level_1\",
                    \"political\"
                    ]
                    },
                    {
                    \"long_name\": \"Suisse\",
                    \"short_name\": \"CH\",
                    \"types\": [
                    \"country\",
                    \"political\"
                    ]
                    },
                    {
                    \"long_name\": \"1215\",
                    \"short_name\": \"1215\",
                    \"types\": [
                    \"postal_code\"
                    ]
                    }
                    ],
                    \"formatted_address\": \"Genève Aéroport, Route de l'Aéroport 21, 1215 Le Grand-Saconnex, Suisse\",
                    \"geometry\": {
                    \"location\": {
                    \"lat\": 46.23700969999999,
                    \"lng\": 6.1091564
                    },
                    \"location_type\": \"APPROXIMATE\",
                    \"viewport\": {
                    \"northeast\": {
                    \"lat\": 46.2383586802915,
                    \"lng\": 6.110505380291502
                    },
                    \"southwest\": {
                    \"lat\": 46.2356607197085,
                    \"lng\": 6.107807419708498
                    }
                    }
                    },
                    \"place_id\": \"ChIJN5MjroBkjEcRMKa4TvKpEeU\",
                    \"types\": [
                    \"airport\",
                    \"establishment\",
                    \"point_of_interest\"
                    ]

                  }"));
  return [
    "geo"=>$geo
  ];
});
$factory->define(App\Run::class, function (Faker\Generator $faker){
   
    return [
        //"user_id"=>function(){return \App\User::find(1)->id;},
        //"car_id"=>function(){return factory(App\Car::class)->create()->id;},
//        "geo_from"=>$geoFrom,
//        "geo_to"=>$geoTo,
        "artist"=>$faker->name,
        "nb_passenger"=>$faker->numberBetween(1,12),
        "note"=>$faker->text,
        "planned_at"=>$faker->dateTimeBetween("+13 days","+15 days"),
    ];
});
$factory->define(App\Group::class, function (Faker\Generator $faker){
    return [
        "color" => App\Http\Helpers\Helper::getRandomGroupColor(),
        "active"=>true
    ];
});
