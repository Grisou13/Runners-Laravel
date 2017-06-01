<?php
/**
*User: Joel.DE-SOUSA
*/
namespace Lib\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use SoftDeletes;
  protected $fillable = [
      "filename","original","type","user_id"
  ];

  public function setType($type){
    $this->type = $type;
  }
  public function scopeOfType($query,$type){
    return $query->where("type",$type)->orderBy("created_at","desc")->first();
  }
  public function getUrlAttribute()
  {
    return url($this->filename);
  }
  public function user()
  {
      return $this->belongsTo(User::class);
  }
}
