<?php

namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ["name"];
    public function users()
    {
      return $this->morphedByMany(User::class,"statusable");
    }
}
