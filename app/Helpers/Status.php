<?php

namespace App\Helpers;
class StatusNotFoundException extends \Exception{}

// Class of statics methods for manage status
class Status{
  /**
   * @return array All the status available in the app
   */
  public static function getAll(){
    return config("status");
  }
  /**
   * [getStatusForRessource get status for ressources like cars, users, etc...]
   * @param  string  $resName [name of the resssource]
   * @return array
   */
  public static function getStatusForRessource($resName){
    return config("status.{$resName}");
  }
  /**
   * shorthand for getting a resource status
   * This method accepts 1 argument, which must be either the status key of a resource, or a status name.
   * The status key will be checked first. Be wise!
   * @return array
   */
  public static function __callStatic($name, $arguments)
    {
        // Note : la valeur de $name est sensible à la casse.
        if(preg_match('/^get(\w+)Status/',$name,$matches)){
          $name = strtolower($matches[1]);
            \Log::debug("IN CLASS Status going to do ".$name." with args: ".print_r($arguments,true));
            if(count($arguments) == 1){
                $ret = self::getStatusKey($name,$arguments[0]);
                if($ret === null)
                    $ret = self::getStatusName($name,$arguments[0]);
                return $ret;
            }

          return self::getStatusForRessource($name);
        }
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
    \Log::debug("CHECKING VALUE OF STATUS : ".$name." IN ".print_r($statuses,true));
    if(!$statuses)
      return null;
    foreach($statuses as $statKey=>$statName){
        if($statKey == $name) return $statKey;
        if($statName == $name) return $statKey;
    }
    return null;
  }
}
