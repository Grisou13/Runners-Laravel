<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Lib\Models\Waypoint;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;

class TestRunApi extends TestCase
{
    use DatabaseMigrations;
    public function testCreateRun()
    {
      $date = Carbon::now();
      $waypoints = factory(Waypoint::class,2)->make();
      $res = $this->json("POST","/api/runs",["name"=>"Test run","planned_at"=>$date,"waypoints"=>$waypoints]);
      $res->assertStatus(200)->assertJson([
        "title"=>"Test run",
        "planned"=>$date
      ]);
    }
    public function testCreateRunWithouWaypoints()
    {
      $date = Carbon::now();
      $res = $this->json("POST","/api/runs",["name"=>"Test run","planned_at"=>$date]);
      $res->assertStatus(422)->assertJson([
        "errors"=>[
          "waypoints"
        ]
      ]);
    }
    public function testStartRun()
    {

    }
    public function testFinishRun()
    {

    }
    public function testDestroyRun()
    {

    }
    public function testStartEmptyRunFail()
    {

    }
    public function testForceRunStart()
    {

    }
    public function testStartPartiallyFilledRunFail()
    {

    }
    public function testStartFullRun()
    {

    }
}
