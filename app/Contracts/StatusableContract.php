<?php
namespace App\Contracts;
interface StatusableContract {
  public function getStatusRessourceType();
  public function setStatusAttribute($value);
  public function getStatusAttribute();
  public function scopeOfStatus($query, $status);
  public function scopeNotOfStatus($query, $status);
}
