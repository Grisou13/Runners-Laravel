<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:11
 */

namespace Api\Responses\Transformers;

use Dingo\Api\Contract\Http\Request;
use League\Fractal\ParamBag;
use League\Fractal\TransformerAbstract;
use Lib\Models\Car;
use Lib\Models\Setting;

class SettingTransformer extends TransformerAbstract
{
  public function transform(Setting $setting)
  {
    return [
      "id"=>$setting->id,
      "key"=>$setting->key,
      "value"=>$setting->value
    ];
  }
}