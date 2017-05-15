<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $fillable = ["name","display_name"];
    public function permissions()
    {
      return $this->belongsToMany(Permission::class);
    }
}
