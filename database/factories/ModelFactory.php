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
$factory->define(Lib\Models\Schedule::class,function(Faker\Generator $faker){
    $start = \Carbon\Carbon::now("-1h");
    return [
        "start_time"=>$start,
        "end_time"=>$faker->dateTimeBetween("now","+5h"),
        "group_id"=>factory(Lib\Models\Group::class)->create()->id,
    ];
});
$factory->define(Lib\Models\User::class, function (Faker\Generator $faker) {
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
        "group_id"=>factory(Lib\Models\Group::class)->create()->id,
    ];
});

$factory->define(Lib\Models\CarType::class, function(Faker\Generator $faker){
  return [
    "name"=>$faker->unique()->name,
    "description"=>$faker->text,
    "nb_place"=>$faker->numberBetween(2,15)
  ];
});

$factory->define(Lib\Models\Car::class, function (Faker\Generator $faker){
    return [
        "plate_number"=>"VD ".$faker->numberBetween(1000000,200000),
        "brand"=>collect(["BMW","Suzuki","Renault","Hyundai"])->random(),
        "model"=>collect(["Serie 4", "Monospace", "Truc"])->random(),
        "color"=>$faker->colorName,
        "nb_place"=>$faker->numberBetween(3,7),
        "car_type_id"=>function(){return factory(Lib\Models\CarType::class)->create()->id;},
        //"car_type_id"=>factory(\Lib\Models\CarType::class)->create()->id,
        "name"=>$faker->numberBetween(1,18),
    ];
});

$factory->define(Lib\Models\Waypoint::class, function(Faker\Generator $faker){
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
    "name"=>collect(["Nyon centre","Lausanne Gare","Paleo grande scène","Genève aéroport", "Chavannes", "lake geneva hotel"])->random(),
    "geo"=>function($waypoint) use ($geo){
      return $geo;
      $url = "https://maps.googleapis.com/maps/api/geocode/json?region=CH&address=".urlencode($waypoint["name"]);
      $client = new \GuzzleHttp\Client();
      $res = $client->request('GET', $url);
      if($res->getStatusCode() != 200)
        return $geo;
      $body = json_decode($res->getBody(),true);
      return $body["results"][0];
    }
  ];
});
$factory->define(Lib\Models\Run::class, function (Faker\Generator $faker){

    return [
        "name"=>$faker->name,
        "nb_passenger"=>$faker->numberBetween(1,3),
        "note"=>$faker->text,
        "planned_at"=>$faker->dateTimeBetween("+1 days","+5 days"),
    ];
});
$factory->define(Lib\Models\RunSubscription::class, function(Faker\Generator $faker){
  return [
    "status"=>"error"
  ];
});
$factory->define(Lib\Models\Group::class, function (Faker\Generator $faker){
    return [
        "color" => App\Http\Helpers\Helper::getRandomGroupColor(),
        "active"=>true
    ];
});

$factory->define(Lib\Models\Image::class, function (Faker\Generator $faker){
    return [
    ];
});
$factory->state(Lib\Models\Image::class, "license",function (Faker\Generator $faker){
  return [
      "filename" => "exemple-permis-conduire.png",
      "original" => "exemple-permis-conduire.png",
      "type" => "license",
  ];
});
$factory->state(Lib\Models\Image::class, "profile",function (Faker\Generator $faker){
  return [
      "filename" => "example-profile-image.png",
      "original" => "example-profile-image.png",
      "type" => "profile",
      //"user_id" => DB::table('users')->inRandomOrder()->first()
  ];
});
