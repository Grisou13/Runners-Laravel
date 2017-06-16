<?php

namespace Tests\Feature;

use Lib\Models\Car;
use Lib\Models\Run;
use Lib\Models\RunSubscription;
use Lib\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CarWithUserTest extends TestCase
{
  use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateCarWithoutUser()
    {
      factory(Car::class)->create();
      $this->assertEquals(Car::all()->count(),1);
    }
    public function testCreateCarThatIsUsedInRun()
    {
      $car = factory(Car::class)->create();
      /**
       * @var $run Run
       */
      $run = factory(Run::class)->create();
      $sub = new RunSubscription();
      $sub->run()->associate($run);
      $sub->car()->associate($car);
      $sub->save();
      $this->assertEquals($run->cars()->get()->count(),1);
      $this->assertNull($car->user());
      $user = factory(User::class)->create();
      $sub->user()->associate($user);
      $sub->save();
      $this->assertEquals($run->users()->get()->count(),1);
      $this->assertEquals($run->cars()->get()->count(),1);//still only should have 1 car
      $this->assertEquals($car->user()->id,$user->id);
    }
}
