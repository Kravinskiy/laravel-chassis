<?php

namespace Kravinskiy\LaravelChassis\Repositories;

use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotCreateEntityException;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as ChassisException;

abstract class AbstractBaseCreateRepository extends AbstractBaseRepository
{
    /**
     * @param array $data
     * @return Model
     * @throws CanNotCreateEntityException
     * @throws ChassisException
     */
    public function handle(array $data): Model
    {
        try {
            return $this->getModel()::create($data);
        } catch (Exception $exception) {
            throw new CanNotCreateEntityException($exception);
        }
    }
}
