<?php
/**
 * Created by PhpStorm.
 * User: Eric.BOUSBAA
 * Date: 01.03.2017
 * Time: 15:39
 */
namespace Api\Controllers\V1;

use Api\Responses\Transformers\ScheduleTransformer;
use Lib\Models\Group;
use Lib\Models\Schedule;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;

class ScheduleController extends BaseController{
    public function index(Request $request)
    {
        if($request->has("interval")){
            $interval = $request->get("interval");
            //TODO call helper
            return false;
        }
        //todo get from config
        //todo call helper without interval (take from config)
        return false;
//        return $this->response()->collection($group->schedules, new ScheduleTransformer);
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