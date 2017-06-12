<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 01.03.2017
 * Time: 15:39
 */
namespace Api\Controllers\V1;

use Api\Responses\Transformers\ScheduleTransformer;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Query\Builder;
use Lib\Models\Group;
use Lib\Models\Schedule;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;

class ScheduleController extends BaseController{
    public function index(Request $request)
    {
      $query = new Schedule();
      /** @var Builder*/
      $query = $query->newQuery();
      if($request->has("between")) {
        $t = explode(",",$request->get("between"));
        $start = trim($t[0]);
        $end = trim($t[1]);
        $query->where("start_time",">=",$start)->where("end_time", "<",$end);
      }
      
      return $this->response()->collection($query->get(), new ScheduleTransformer);
    }
    public function show(Request $request, Schedule $schedule)
    {
        return $this->response()->item($schedule, new ScheduleTransformer);
    }
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        if($request-has("group"))
        {
            $group = Group::findOrFail($request->get("group"));
            $schedule->group()->associate($group)->save();
            return $this->response()->item($schedule, new ScheduleTransformer);
        }
        $schedule->update($request->except(["token","_token"]));
        return $this->response()->item($schedule, new ScheduleTransformer);
    }
    public function store(CreateScheduleRequest $request)
    {
        $data = $request->except(["_token","token"]);
        $group = Group::find($request->get("group"));
        $schedule = $group->schedules()->create($data);
        return $this->response()->item($schedule, new ScheduleTransformer);
    }
    public function destroy(Request $request, Schedule $schedule)
    {
        $schedule->delete();
        return $this->response->accepted();
    }
}