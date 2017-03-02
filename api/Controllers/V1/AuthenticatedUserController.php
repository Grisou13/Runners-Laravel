<?php

namespace Api\Controllers\V1;
use Api\Controllers\BaseController as Base;
class AuthenticatedUserController extends Base
{
  public function __construct()
  {
    $this->middleware("auth");
  }
  public function me()
  {
    return $this->user();
  }
  public function runs()
  {
    return $this->user()->runs();
  }
  public function schedule()
  {
    return $this->user()->schedule();
  }
}
