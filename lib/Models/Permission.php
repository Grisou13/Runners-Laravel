<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  public $fillable = ["name","display_name"];
}
