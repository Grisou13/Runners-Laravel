<?php
/**
* User: Thomas.RICCI
*/
namespace Api\Controllers\V1;

use Api\Controllers\BaseController;
use Illuminate\Http\Request;

class HomeController extends BaseController
{
    public function home()
    {
        return view("api.home");
    }
    public function ping()
    {
      return "pong";
    }
}
