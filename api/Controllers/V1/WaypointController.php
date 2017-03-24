<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 12.01.2017
 * Time: 13:44
 */

namespace Api\Controllers\V1;

use Lib\Models\Waypoint;
use Lib\Models\User;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Http\Helpers;

class WaypointController extends BaseController
{
    public function index(Request $request)
    {
        return Waypoint::all();
    }
    public function show(Request $request,Waypoint $point)
    {
      return $point;
    }
    public function update(Request $request, Waypoint $point)
    {
        $point->update($request->all());
        $point->save();
        return $point;
    }
    public function store(Request $request)
    {
        $point = new Waypoint;
        $point->fill($request->all());
        $point->save();
        return $point;
    }
    public function destroy(Request $request, Waypoint $point)
    {
        return $point->delete();
    }

}
