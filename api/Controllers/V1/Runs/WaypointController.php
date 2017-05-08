<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1\Runs;

use Api\Controllers\BaseController;
use Lib\Models\Run;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Http\Request;
use Api\Responses\Transformers\RunTransformer;
use Lib\Models\Waypoint;

class WaypointController extends BaseController
{
    public function index(Request $request)
    {
      return $this->response()->collection(Run::all(), new RunTransformer);
    }
    public function show(Request $request, Run $run)
    {
      return $run;
    }
    public function deleteAll(Run $run)
    {
      //TODO implement broadcasting for waypoints
      $run->waypoints()->detach();
      return $run;
    }
    
    public function store(Request $request, Run $run)
    {
        

        
        $waypoints = $request->get("waypoints");
        foreach($waypoints as $point)
        {
          $run->waypoints()->attach($point);
        }
        
        return $run;
    }
    public function delete(Run $run)
    {
        return $run->delete();
    }
}
