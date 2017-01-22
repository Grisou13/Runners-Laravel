<?php

namespace Api\Requests\Filtering;

use Unlu\Laravel\Api\QueryBuilder;
use Unlu\Laravel\Api\UriParser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

  }
