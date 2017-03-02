<?php
/**
 * Created by PhpStorm.
 * User: Thomas.RICCI
 * Date: 13.01.2017
 * Time: 10:19
 */

namespace Api\Responses;


use Dingo\Api\Http\Response\Format\Format as DefaultFormat;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;

class Json extends DefaultFormat
{
    /**
     * Format an Eloquent model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return string
     */
    public function formatEloquentModel($model)
    {
        if($this->response->isOk())
            return $this->encode($model->toArray());
        return $this->encode($model->toArray());

    }

    /**
     * Format an Eloquent collection.
     *
     * @param \Illuminate\Database\Eloquent\Collection $collection
     *
     * @return string
     */
    public function formatEloquentCollection($collection)
    {
        if ($collection->isEmpty()) {
            return $this->encode([]);
        }
        if($this->response->isOk())
            return $this->encode($collection->toArray());
        return $this->encode($collection->toArray());
    }

    /**
     * Format an array or instance implementing Arrayable.
     *
     * @param array|\Illuminate\Contracts\Support\Arrayable $content
     *
     * @return string
     */
    public function formatArray($content)
    {
        $content = $this->morphToArray($content);

        array_walk_recursive($content, function (&$value) {
            $value = $this->morphToArray($value);
        });
        if($this->response->isOk())
            return $this->encode($content);
        return $this->encode($content);
    }

    /**
     * Get the response content type.
     *
     * @return string
     */
    public function getContentType()
    {
        return 'application/json';
    }

    /**
     * Morph a value to an array.
     *
     * @param array|\Illuminate\Contracts\Support\Arrayable $value
     *
     * @return array
     */
    protected function morphToArray($value)
    {
        return $value instanceof Arrayable ? $value->toArray() : $value;
    }

    /**
     * Encode the content to its JSON representation.
     *
     * @param string $content
     *
     * @return string
     */
    protected function encode($content)
    {
        return json_encode($content);
    }
}
