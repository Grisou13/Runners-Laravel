<?php
//TODO add some stuff here :D

if( ! function_exists("transform"))
{
  function transform($obj)
  {
    app('Dingo\Api\Transformer\Factory')->transform($obj);
  }
}