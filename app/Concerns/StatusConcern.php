<?php

namespace App\Concerns;
use App\Helpers\Status;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait StatusConcern{
  protected $statusRessourceType = null;
    public static function bootStatusConcernTrait()
    {
        //
    }
  public function getStatusRessourceType(){
    return !$this->statusRessourceType ? strtolower((new \ReflectionClass($this))->getShortName()) : $this->statusRessourceType ;
  }
  public function setStatusAttribute($value){
    return $this->attributes["status"] = $this->lookupStatus($value);
  }
  public function getStatusAttribute(){
    return array_key_exists("status",$this->attributes) ? $this->attributes["status"] : null;
  }
  protected function lookupStatus($val){

    return Status::getStatus(self::class,$val);
  }
  protected function getPublishedStatusName($statusName){
    return Status::getStatusName($this,$statusName);
  }
  protected function prepareStatusForQuery($type)
  {
    $status = [];
    if($type instanceof Collection || is_array($type))
      foreach($type as $t)
        $status[] = Status::getStatus($this,$t);
    else
      $status = [Status::getStatus($this,$type)];
    return $status;
  }
  /**
   * @param $query Builder
   * @param $type array|string
   * @return Builder
   */
    public function scopeOfStatus($query, $type)
    {
      return $query->whereIn('status', $this->prepareStatusForQuery($type));
    }

  /**
   * @param $query Builder
   * @param $type array|string
   * @return Builder
   */
    public function scopeNotOfStatus($query, $type)
    {
      return $query->whereNotIn('status', $this->prepareStatusForQuery($type));
    }
}
