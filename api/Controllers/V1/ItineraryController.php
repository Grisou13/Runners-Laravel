<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 10.02.2017
 * Time: 15:35
 */

namespace Api\Controllers\V1;

use Lib\Models\Itinerary;

class ItineraryController
{
  public function show(Itinerary $it){
    return $it;
  }
  public function store(Request $request){
    if($request->has("waypoints")){
      $request->get("waypoints");
    }
  }
}