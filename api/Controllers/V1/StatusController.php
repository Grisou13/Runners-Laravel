<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.03.2017
 * Time: 10:46
 */

namespace Api\Controllers\V1;


use Api\Controllers\BaseController;

class StatusController extends BaseController
{
  public function index()
  {
    return config("status");
  }
}