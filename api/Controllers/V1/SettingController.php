<?php

namespace Api\Controllers\V1;

use Api\Controllers\BaseController;
use Lib\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class SettingController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Setting::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      if(!$this->user()->hasPermissionTo("create settings"))
        throw new UnauthorizedHttpException("you can't update a setting. Please contact administrator");
      return Setting::create($request->except(["token","_token"]));
    }
  
  /**
   * Display the specified resource.
   *
   * @param Setting $setting
   * @return \Illuminate\Http\Response|Setting
   */
    public function show(Setting $setting)
    {
        return $setting;
    }
  
  
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request $request
   * @param Setting $settings
   * @return \Illuminate\Http\Response|Setting
   */
    public function update(Request $request, Setting $settings)
    {
        if(!$this->user()->hasPermissionTo("edit settings"))
          throw new UnauthorizedHttpException("you can't update a setting. Please contact administrator");
        $settings->update($request->except(["token","_token"]));
        return $settings;
    }
  
  /**
   * Remove the specified resource from storage.
   *
   * @param Setting $settings
   * @return \Illuminate\Http\Response
   */
    public function destroy(Setting $settings)
    {
      if(!$this->user()->hasPermissionTo("delete settings"))
        throw new UnauthorizedHttpException("you can't update a setting. Please contact administrator");
      $settings->delete();
    }
}
