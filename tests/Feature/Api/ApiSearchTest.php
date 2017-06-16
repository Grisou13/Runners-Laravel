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
      $cars = factory(Car::class,3)->create();
      $name = $cars[0]->name;
      $res = $this->getJson("/api/cars/search?q=".urlencode($name),["x-access-token"=>$user->getAccessToken()]);
//      $res->dump();
      $res->assertStatus(200)->assertJson([
        [
          "name"=>$cars[0]->name
        ]
      ]);
  
      $this->assertEquals(count($res->json()), 1);
    }
}
