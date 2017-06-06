<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 03.03.2017
 * Time: 10:46
 */

namespace Api\Controllers\V1;

use Api\Controllers\BaseController;
use App\Helpers\Status;
use Dingo\Api\Http\Request;


class StatusController extends BaseController
{
  public function index()
  {
    return config("status");
  }
  public function model(Request $request, $model)
  {
      return Status::getStatusForRessource($model);
  }
  public function vehicle()
  {
    return Status::getStatusForRessource("car");
  }
}