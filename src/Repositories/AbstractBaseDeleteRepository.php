<?php

namespace Kravinskiy\LaravelChassis\Repositories;

use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotDeleteEntityException;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as ChassisException;

abstract class AbstractBaseDeleteRepository extends AbstractBaseRepository
{
    /**
     * @param string $id
     * @return int
     * @throws CanNotDeleteEntityException
     * @throws ChassisException
     */
    public function handle(string $id)
    {
        try {
            return $this->getModel()::destroy($id);
        } catch (Exception $exception) {
            throw new CanNotDeleteEntityException($exception);
        }
    }
}
