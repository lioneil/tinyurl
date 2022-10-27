<?php

namespace App\Services;

abstract class Service
{
    /**
     * Array of parameters used in
     * querying resource.
     *
     * @var object
     */
    public $params;

    /**
     * The model class of the service.
     *
     * @var string
     */
    public $model;

    /**
     * Set service parameters.
     *
     * @param array $params
     * @return $this
     */
    public function params ($params)
    {
        $this->params = (object) array_merge([
            'q' => null,
            'page' => 1,
            'per_page' => 15,
        ], $params);

        return $this;
    }

    /**
     * Return an initialized instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function model ()
    {
        return new $this->model;
    }
}
