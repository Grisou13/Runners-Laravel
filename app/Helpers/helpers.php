<?php
//TODO add some stuff here :D

if( ! function_exists("transform"))
{
  function transform($obj)
  {
    app('Dingo\Api\Transformer\Factory')->transform($obj);
  }
}
if( !function_exists("app_version"))
{
  function app_version()
  {
    $version_composer = json_decode(file_get_contents(base_path("composer.json")), true);
    if(array_key_exists("version", $version_composer))
      $version = $version_composer["version"];
    else
      $version = "v0.0.0";
    return $version;
  }
}