<?php

namespace Tests\Feature\Api;

use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\Waypoint;
use \Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddCarsToRun extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function addCarToRun()
    {
      $run = factory(Run::class)->create();
      $run->waypoints()->save(factory(Waypoint::class,2)->make());
      $car = factory(Car::class)->make();
      $res = $this->json("POST","/api/runs/{$run->id}/runners",["car"=>$car], ["x-access-token"=>"root"]);
      $res->assertStatus(201);

      $this->assert();

    }

  /**
   * @test
   */
    public function addCarTypeToRun()
    {

    }
}
