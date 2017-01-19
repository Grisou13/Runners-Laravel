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
        "access_token"=>str_random(255),
        "group_id"=>factory(\App\Group::class)->create()->id
    ];
});

$factory->define(App\Car::class, function (Faker\Generator $faker){
    return [
        "plate_number"=>"VD ".$faker->numberBetween(1000000,200000),
        "brand"=>$faker->company,
        "model"=>$faker->word,
        "color"=>$faker->colorName,
        "nb_place"=>$faker->numberBetween(3,7),
        "comment"=>"",
        "name"=>$faker->word,
        "car_type_id"=>function(){return factory(App\CarType::class)->create()->id;}
    ];
});
$factory->define(App\CarType::class, function (Faker\Generator $faker){
    return [
        "type"=>$faker->unique()->word,
        "description"=>$faker->text
    ];
});
$factory->define(App\Run::class, function (Faker\Generator $faker){
    return [
        "start_at"=>$faker->dateTimeBetween("now","+13 days"),
        "end_at"=>$faker->dateTimeBetween("+13 days","+15 days"),
        "user_id"=>function(){return \App\User::find(1)->id;},
        "car_id"=>function(){return factory(App\Car::class)->create()->id;},
        "geo_from"=>"{
         \"address_components\" : [
            {
               \"long_name\" : \"Sydney\",
               \"short_name\" : \"Sydney\",
               \"types\" : [ \"colloquial_area\", \"locality\", \"political\" ]
            },
            {
               \"long_name\" : \"Nouvelle-Galles du Sud\",
               \"short_name\" : \"NSW\",
               \"types\" : [ \"administrative_area_level_1\", \"political\" ]
            },
            {
               \"long_name\" : \"Australie\",
               \"short_name\" : \"AU\",
               \"types\" : [ \"country\", \"political\" ]
            }
         ],
         \"formatted_address\" : \"Sydney Nouvelle-Galles du Sud, Australie\",
         \"geometry\" : {
            \"bounds\" : {
               \"northeast\" : {
                  \"lat\" : -33.5781409,
                  \"lng\" : 151.3430209
               },
               \"southwest\" : {
                  \"lat\" : -34.118347,
                  \"lng\" : 150.5209286
               }
            },
            \"location\" : {
               \"lat\" : -33.8688197,
               \"lng\" : 151.2092955
            },
            \"location_type\" : \"APPROXIMATE\",
            \"viewport\" : {
               \"northeast\" : {
                  \"lat\" : -33.5782519,
                  \"lng\" : 151.3429976
               },
               \"southwest\" : {
                  \"lat\" : -34.118328,
                  \"lng\" : 150.5209286
               }
            }
         },
         \"place_id\" : \"ChIJP3Sa8ziYEmsRUKgyFmh9AQM\",
         \"types\" : [ \"colloquial_area\", \"locality\", \"political\" ]
      }",
        "geo_to"=>"{
         \"address_components\" : [
            {
               \"long_name\" : \"Sydney\",
               \"short_name\" : \"Sydney\",
               \"types\" : [ \"colloquial_area\", \"locality\", \"political\" ]
            },
            {
               \"long_name\" : \"Nouvelle-Galles du Sud\",
               \"short_name\" : \"NSW\",
               \"types\" : [ \"administrative_area_level_1\", \"political\" ]
            },
            {
               \"long_name\" : \"Australie\",
               \"short_name\" : \"AU\",
               \"types\" : [ \"country\", \"political\" ]
            }
         ],
         \"formatted_address\" : \"Sydney Nouvelle-Galles du Sud, Australie\",
         \"geometry\" : {
            \"bounds\" : {
               \"northeast\" : {
                  \"lat\" : -33.5781409,
                  \"lng\" : 151.3430209
               },
               \"southwest\" : {
                  \"lat\" : -34.118347,
                  \"lng\" : 150.5209286
               }
            },
            \"location\" : {
               \"lat\" : -33.8688197,
               \"lng\" : 151.2092955
            },
            \"location_type\" : \"APPROXIMATE\",
            \"viewport\" : {
               \"northeast\" : {
                  \"lat\" : -33.5782519,
                  \"lng\" : 151.3429976
               },
               \"southwest\" : {
                  \"lat\" : -34.118328,
                  \"lng\" : 150.5209286
               }
            }
         },
         \"place_id\" : \"ChIJP3Sa8ziYEmsRUKgyFmh9AQM\",
         \"types\" : [ \"colloquial_area\", \"locality\", \"political\" ]
      }",
        "flight_num"=>$faker->numberBetween(0,400),
        "note"=>$faker->text
    ];
});
$factory->define(App\Group::class, function (Faker\Generator $faker){
    return [
        "active"=>true
    ];
});