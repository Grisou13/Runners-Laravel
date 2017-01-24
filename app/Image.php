<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
  protected $fillable = [
      "filename","original","type","user_id"
  ];
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
