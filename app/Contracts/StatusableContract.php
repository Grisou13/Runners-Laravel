<?php
namespace App\Contracts;
use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Query\Builder;

interface StatusableContract {
  /**
   * This defines which type of status it should look for.
   * As of rught now, where in status.* it should search.
   * @return string
   */
  public function getStatusRessourceType();
  
  /**
   * Eloquent mutator.
   * This method will transform any value into a valid status for the model.
   * @param string $value
   * @return void
   */
  public function setStatusAttribute($value);
  
  /**
   * @return string
   */
  public function getStatusAttribute();
  
  /**
   * Helper scope
   * @param $query
   * @param $status
   * @return Builder
   */
  public function scopeOfStatus($query, $status);
  
  /**
   * Helper scope
   * @param $query
   * @param $status
   * @return Builder
   */
  public function scopeNotOfStatus($query, $status);
}
