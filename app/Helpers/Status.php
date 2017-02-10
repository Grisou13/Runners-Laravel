<?php

namespace App\Helpers;
class StatusNotFoundException extends \Exception{}

// Class of statics methods for manage status
class Status{
  /**
   * @return array All the status available in the app
   */
  public static function getAllStatuses(){
    return config("status");
  }
  /**
   * [getStatusForRessource get status for ressources like cars, users, etc...]
   * @param  string  $resName [name of the resssource]
   * @return array
   */
  public static function getStatusForRessource($resName){
    return array_keys(config("status.{$resName}"));
  }
  /**
   * [getUserStatus get the all the status for all users]
   * @return array
   */
  public static function getUserStatus(){
    return self::getStatusForRessource("user");
  }
  /**
   * getStatusName get the status of specific ressource
   * @param  Object|string $ressource Car, User | "car", "user"
   * @param  string $name      name of the status key
   * @return string
   */
  public static function getStatusName($ressource,$name){
    if(is_object($ressource) && method_exists($ressource,"getStatusRessourceType"))
      return config("status.".$ressource->getStatusRessourceType().".".$name);
    else
      return config("status.". $ressource .".". $name);
  }
  /**
   * getStatusKey get the status corresponding of the key
   * @param  Object|string $ressource Car, User | "car", "user"
   * @param  string $name      name of the status key
   * @return string           
   */
  public static function getStatusKey($ressource,$name){
    if(is_object($ressource) && method_exists($ressource,"getStatusRessourceType"))
      $statuses = config("status.".$ressource->getStatusRessourceType());
    else
      $statuses = config("status.{$ressource}");

    foreach($statuses as $statKey=>$statName){
      if($statName == $name) return $statKey;
    }
    throw new StatusNotFoundException;
  }
}
