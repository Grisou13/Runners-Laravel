<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ApiAuthentificationTest extends TestCase
{
  use DatabaseMigrations;
  
  /**
   * @test
   */
  public function unauthenticated()
  {
    $res = $this->getJson("/api/users");
    $res->assertStatus(401);
  }
  
  /**
   * @test
   */
  public function userNotFoundAuth()
  {
    $res = $this->getJson("/api/users",["x-access-token"=>"not-found"]);
    $res->assertStatus(401);
  }
  
  /**
   * @test
   */
  public function authenticated()
  {
    $user = $this->createDefaultUser();
    $res = $this->getJson("/api/users",["x-access-token"=>$user->getAccessToken()]);
    $res->assertStatus(200);
  }
}
