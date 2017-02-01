<?php
/**
* User: Thomas.RICCI
*/
namespace Api\Requests\Filtering;

use Unlu\Laravel\Api\QueryBuilder;
use Unlu\Laravel\Api\UriParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
/**
* Override of the normal QueryBuilder, because it does not allow to use it on only 1 model
* This class can be constructed and used with a single model isntance, and still use query params to filter it
*/
class RequestFilter extends QueryBuilder
{

      public function __construct(Model $model, Request $request)
      {
          $this->orderBy = config('api-query-builder.orderBy');
          $this->limit = config('api-query-builder.limit');
          $this->excludedParameters = array_merge($this->excludedParameters, config('api-query-builder.excludedParameters'));
          $this->model = $model;
          $this->uriParser = new UriParser($request);
          if($model->exists)
            $this->query = $this->model->newQuery()->where("id",$model->id);
          else
            $this->query = $this->model->newQuery();
      }
      public function filterByStatus($query, $value, $operator)
      {
        return $query->whereHas('status', function($q) use ($value, $operator) {
          return $q->where('name', $operator, $value);
        });
      }

  }
