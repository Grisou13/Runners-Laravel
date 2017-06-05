<?php

namespace Tests\Feature;

use App\Events\RunSavedEvent;
use App\Events\RunSubscriptionSavedEvent;
use App\Events\RunSubscriptionSavingEvent;
use Illuminate\Support\Facades\Bus;
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
    public function testEventSavedIsFiredWhenSavingRun()
    {
      Event::fake();
      $user = $this->createDefaultUser();
      $run = factory(Run::class)->create();
      $car = factory(Car::class)->create();
      $sub = new RunSubscription();
      $sub->run()->associate($run);
      $sub->user()->associate($user);
      $sub->car()->associate($car);
      $sub->save();

      Event::assertDispatched(RunSubscriptionSavedEvent::class, function ($e) use($sub) {
        return $e->run_subscription->id === $sub->id;
      });
      
    }
}
