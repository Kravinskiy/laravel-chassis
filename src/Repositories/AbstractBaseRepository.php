<?php

namespace Kravinskiy\LaravelChassis\Repositories\Chassis;

use Kravinskiy\LaravelChassis\Models\ModelInterface;

abstract class AbstractBaseRepository
{
    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * @param ModelInterface $model
     */
    protected function setModel(ModelInterface $model)
    {
        $this->model = $model;
    }

    /**
     * @return ModelInterface
     */
    protected function getModel(): ModelInterface
    {
        return $this->model;
    }
}
