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
use App\Http\Requests\CreateGroupScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Api\Controllers\BaseController;
use Illuminate\Http\Request;

class GroupScheduleController extends BaseController{
    public function index(Request $request, Group $group)
    {
        return $this->response()->collection($group->schedules, new ScheduleTransformer);
    }
    public function show(Request $request, Group $group, Schedule $schedule)
    {
        return $this->response()->item($schedule, new ScheduleTransformer);
    }
    public function update(UpdateScheduleRequest $request, Group $group, Schedule $schedule)
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
    public function store(CreateGroupScheduleRequest $request, Group $group)
    {
        $data = $request->except(["_token","token"]);
        $schedule = $group->schedules()->create($data);

        return $this->response()->item($schedule, new ScheduleTransformer);

    }
    public function destroy(Request $request, Schedule $schedule)
    {
        $schedule->delete();
        return $schedule;
    }
}
