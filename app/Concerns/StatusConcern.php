<?php

namespace App\Concerns;
use App\Helpers\Status;
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
    return $this->getPublishedStatusName($this->attributes["status"]);
  }
  protected function lookupStatus($val){

    return Status::getStatusKey($this,$val);
  }
  protected function getPublishedStatusName($statusName){
    return Status::getStatusName($this,$statusName);
  }
    public function scopeOfStatus($query, $type)
    {
        return $query->where('status', $type);
    }
}
