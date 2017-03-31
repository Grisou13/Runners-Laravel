<?php

namespace Tests\Feature\Api;

use App\Events\RunSavedEvent;
use App\Events\RunSubscriptionSavedEvent;
use App\Helpers\Status;
use Illuminate\Support\Facades\Event;
use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RunStatusTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRunHasStatusOfReady()
    {
      $user = $this->createDefaultUser();
      $run = factory(Run::class)->create();
      $car = factory(Car::class)->create();
      $sub = new RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate($user);
      $sub->car()->associate($car);
      $sub->save();

      $res = $this->getJson("/api/runs/".$run->id,["x-access-token"=>$user->getAccessToken()]);
      $res->assertStatus(200)->assertJson([
          "status"=>"ready",
          "runners"=>[[
            "status"=>"ready_to_go"
            ]
          ]
      ]);


    }
    public function testRunFilterOnIndex()
    {
      
      $user = $this->createDefaultUser();
      $run = factory(Run::class)->create();
      
      $car = factory(Car::class)->create();
      $sub = new RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate($user);
      $sub->car()->associate($car);
      $sub->save();

  
      $run2 = factory(Run::class)->create();
      $sub2 = new RunSubscription();
      $sub2->run()->associate($run2);
      $sub2->user()->associate($user);
      $sub2->save();
      
      $run3 = factory(Run::class)->create();
      $car3 = factory(Car::class)->create();
      $sub3 = new RunSubscription();
      $sub3->run()->associate($run3);
      $sub3->car()->associate($car3);
      $sub3->save();
      $res = $this->getJson("/api/runs/?status=ready",["x-access-token"=>$user->getAccessToken()]);
      
      //we should only get 1 item with this id
      $res->assertStatus(200)->assertJson([
        ["status"=>"ready",
          "runners"=>[[
            "status"=>"ready_to_go"
        ]]],
      ]);
      $this->assertEquals($car->status,"taken"); //the status for the first car should be taken
      //only one of the 3 runs created should be listed
      
      $this->assertCount(1,$res->json());
  
      $res = $this->getJson("/api/runs/?status=error",["x-access-token"=>$user->getAccessToken()]);
      //we should only get 1 item with this id
      $res->assertStatus(200)->assertJson([
        [
          "status"=>"error"
        ]
      ]);
      //only one of the 1 runs created should be listed
      $this->assertCount(1,$res->json());
      $res = $this->getJson("/api/runs/?status=missing_cars",["x-access-token"=>$user->getAccessToken()]);
      //we should only get 1 item with this id
      $res->assertStatus(200)->assertJson([
        [
          "status"=>"missing_cars"
        ]
      ]);
      //only one of the 1 runs created should be listed
      $this->assertCount(1,$res->json());
    }
}
