<?php

namespace App\Concerns;

trait StatusConcern{
  protected $statusRessourceType = null;
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
    return Status::getStatusKey($this->getStatusRessourceType(),$val);
  }
  protected function getPublishedStatusName($statusName){
    return Status::getStatusName($this->getStatusRessourceType(),$statusName);
  }
}
