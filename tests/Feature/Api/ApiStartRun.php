<?php

namespace Tests\Featur\Api;

use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiStartRun extends TestCase
{
  use DatabaseMigrations;
    
  public function testStartRunOk()
  {
  
    $user = $this->createDefaultUser();
    $user->assignRole("admin");
    $run = factory(Run::class)->create();
    $run->nb_passenger = 1; //the run only wants one person
    $car = factory(Car::class)->create();
    $car->nb_place = 5;
    $car->save(); //the car has now 5 seats
    $user2 = factory(User::class)->create();
    
    $sub = new RunSubscription();
    $sub->run()->associate($run);
    $sub->car()->associate($car);
    $sub->user()->associate($user2);
    $sub->save();
    $res = $this->postJson("/api/runs/{$run->id}/start",[],["x-access-token"=>$user->getAccessToken()]);
    $res->assertStatus(200);
    $res->assertJson([
      "status"=>"gone"
    ]);
    
    
    $this->assertEquals($car->fresh()->status,"gone");
    $this->assertEquals($user2->fresh()->status,"gone");
    $this->assertEquals($run->fresh()->status,"gone");
  }
}
