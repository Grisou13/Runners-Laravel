<?php
namespace Lib\Models\Relationships;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SortableBelongsToMany extends BelongsToMany
{
  protected $orderColumn;
  public function __construct(Builder $query, Model $parent, $table, $foreignKey, $otherKey, $relationName = null, $orderColumn = "order")
  {
    $this->orderColumn = $orderColumn;
    parent::__construct($query, $parent, $table, $foreignKey, $otherKey, $relationName);
  }
  public function attach($id, array $attributes = [], $touch = true)
  {
    $attributes = array_merge($attributes, [$this->getOrderColumnName()=> $this->getNextPosition()]);
    return parent::attach($id, $attributes, $touch);
  }
  public function getOrderColumnName()
  {
    return $this->orderColumn;
  }
  public function getNextPosition()
  {
    return 1 + $this->newPivotQuery()->max($this->getOrderColumnName());
  }
}
