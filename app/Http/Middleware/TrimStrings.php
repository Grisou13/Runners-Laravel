<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 17.02.2017
 * Time: 14:52
 */
namespace App\Http\Middleware;
use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;
class TrimStrings extends BaseTrimmer
{
  /**
   * The names of the attributes that should not be trimmed.
   *
   * @var array
   */
  protected $except = [
    'password',
    'password_confirmation',
  ];
}