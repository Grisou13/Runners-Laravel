<?php

namespace Tests\Feature\Api;

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
        "runners"=>[
          "status"=>"ready_to_go"
        ]
      ]);


    }
    public function testRunFilterOnIndex()
    {
      $this->assertTrue(true);
    }
}
