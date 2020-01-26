<?php

namespace Kravinskiy\LaravelChassis\Repositories\Chassis;

use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException;
use Kravinskiy\LaravelChassis\Models\Chassis\DatabaseModel;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as ChassisException;

abstract class AbstractBaseGetRepository extends AbstractBaseRepository
{
    /**
     * @param string $id
     * @return DatabaseModel|null
     * @throws CanNotGetEntityException
     * @throws ChassisException
     */
    public function handle(string $id): ?DatabaseModel
    {
        try {
            return $this->getModel()::find($id);
        } catch (Exception $exception) {
            throw new CanNotGetEntityException($exception);
        }
    }
}
