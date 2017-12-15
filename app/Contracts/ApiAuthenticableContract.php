<?php

namespace App\Contracts;

interface ApiAuthenticableContract{
  public static function getAccessTokenKey();
  public function getAccessToken();
  public function setAccesstokenAttribute($value);
  public function generateToken();
}
