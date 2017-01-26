<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
  protected $fillable = [
      "filename","original","type","user_id"
  ];
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
