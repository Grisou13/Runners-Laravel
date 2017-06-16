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
    public function spec()
    {
      $spec =  file_get_contents(base_path("docs/api.yaml"));
      $re = '/(?:host:)(\s?\w.*)/';
      
      function remove_http($url) {
        $disallowed = array('http://', 'https://');
        foreach($disallowed as $d) {
          if(strpos($url, $d) === 0) {
            return str_replace($d, '', $url);
          }
        }
        return $url;
      }
      $subst = 'host: '.remove_http(config("app.url"));
      return preg_replace($re, $subst, $spec);
    }
}
