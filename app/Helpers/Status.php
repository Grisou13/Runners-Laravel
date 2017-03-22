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
            if(count($arguments) == 1){
                return self::getStatus($name,$arguments[0]);
            }

          return self::getStatusForRessource($name);
        }
    }
    public static function  getStatus($resource, $name)
    {
      return self::getStatusKey($resource,$name);
    }
  /**
   * getStatusName get the status of specific ressource
   * @param  Object|string $ressource Car, User | "car", "user"
   * @param  string $name      name of the status key
   * @return string
   */
  public static function getStatusName($ressource,$key){

      return config("status.". self::resolveResourceName($ressource) .".". $key);
  }
  
  /**
   * Resolves a class_name, a class object or string to a valid status type
   * @param $r
   * @return string
   */
  protected static function resolveResourceName($r)
  {
    if(is_object($r) && method_exists($r,"getStatusRessourceType"))
        return str_singular(snake_case($r->getStatusRessourceType()));
    elseif(is_string($r))
      return str_singular(snake_case(snake_case(basename(str_replace('\\', '/',$r)))));
    return str_singular(snake_case(basename(str_replace('\\', '/', get_class($r)))));
  }
  /**
   * getStatusKey get the status corresponding of the key
   * @param  Object|string $ressource Car, User | "car", "user"
   * @param  string $name      name of the status key
   * @return string
   */
  public static function getStatusKey($ressource,$name){
    
    $statuses = collect(config("status.".self::resolveResourceName($ressource),[]));
    $index = $statuses->keys()->search($name);
    if($index !== false)
      return $statuses->keys()[$index];
    else{
      $index = $statuses->values()->search($name);
      if($index !== false)
        return $statuses->keys()[$index];
    }
    return null;
    
  }
}
