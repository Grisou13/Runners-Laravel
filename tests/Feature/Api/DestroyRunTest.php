<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DestroyRunTest extends TestCase
{
  use DatabaseMigrations, DispatchesJobs;
  
  /**
   * @test
   */
  public function normalRun()
  {
    $user = $this->createDefaultUser();
    $run = factory(Run::class)->create();
    $res = $this->deleteJson("/api/runs/{$run->id}",[],["x-access-token"=>$user->getAccessToken()]);
    $res->assertStatus(200);
    $this->assertNotNull(Run::withTrashed()->find($run->id)->deleted_at);
    $this->assertNotNull(Run::withTrashed()->find($run->id)->ended_at);
  }
  
  /**
   * @test
   */
  public function runWithSubs()
  {
    /**
     * @var $run Run
     */
    
    $run = factory(Run::class)->create();
    factory(RunSubscription::class, 3)->create(["run_id"=>$run->id]);
    $this->assertEquals($run->subscriptions()->getResults()->count(), 3);//the run must now have 3 subs
    $user = $this->createDefaultUser();
    $res = $this->deleteJson("/api/runs/{$run->id}",[],["x-access-token"=>$user->getAccessToken()]);
    $res->assertStatus(200);
    $this->assertEquals($run->subscriptions()->getResults()->count(),0);// now that the run is deleted, we should never get subscriptions.
    $this->assertNotNull(Run::withTrashed()->find($run->id)->deleted_at);
    $this->assertNotNull(Run::withTrashed()->find($run->id)->ended_at);
  }
  
  /**
   * @test
   */
  public function stopRun()
  {
    /**
     * @var $run Run
     */
    $this->seed("RoleSeeder");
    $user = $this->createDefaultUser();
    $user->assignRole("admin");
    $run = factory(Run::class)->create();
    $car = factory(Car::class)->create();
    factory(RunSubscription::class, 3)->create(["run_id"=>$run->id])->each(function($sub) use($car, $user){
      $sub->user()->associate($user);
      $sub->car()->associate($car);
      $sub->save();
    });
    $this->assertEquals($run->subscriptions()->getResults()->count(), 3);//the run must now have 3 subs
    
    $res = $this->postJson("/api/runs/{$run->id}/stop",[],["x-access-token"=>$user->getAccessToken()]);

    $res->assertStatus(200);
    $this->assertEquals($run->subscriptions()->getResults()->count(),0);// now that the run is deleted, we should never get subscriptions.
    $this->assertNotNull($run->fresh()->ended_at);
  
  }
  
}
