<?php

namespace App\Concerns;

trait ApiAuthenticableConcern{
  public static function getAccessTokenKey()
  {
    return "accesstoken";
  }
  public function getAccessToken()
  {
    return array_key_exists($this->getAccessTokenKey(),$this->attributes) ? $this->attributes[$this->getAccessTokenKey()]: false;
  }
  public function setAccesstokenAttribute($value)
  {
      $this->attributes[$this->getAccessTokenKey()]= $value ? $value : $this->generateToken();
  }
  public function generateToken()
  {
      return $this->accesstoken = bcrypt(Carbon::now()->toDateString() . $this->email . $this->name);
  }
}
