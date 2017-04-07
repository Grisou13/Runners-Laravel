<?php

namespace Tests\Feature\Api;

use Lib\Models\Car;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiSearchTest extends TestCase
{
    use DatabaseMigrations;
    public function testUserSearchHasResults()
    {
      $user = $this->createDefaultUser();
      $res = $this->getJson("/api/users/search?q=roo",["x-access-token"=>$user->getAccessToken()]);
      $res->assertStatus(200)->assertJson([
        [
          "name"=>$user->name,
          "email"=>$user->email
        ]
      ]);
      
      $this->assertEquals(count($res->json()), 1);
    }
    public function testCarSearchHasResults()
    {
      $user = $this->createDefaultUser();
      $car = factory(Car::class)->create();
      $name = $car->name[0];
      $res = $this->getJson("/api/cars/search?q=$name",["x-access-token"=>$user->getAccessToken()]);
      $res->assertStatus(200)->assertJson([
        [
          "name"=>$car->name,
        ]
      ]);
  
      $this->assertEquals(count($res->json()), 1);
    }
}
