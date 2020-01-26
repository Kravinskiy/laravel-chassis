<?php

namespace Kravinskiy\LaravelChassis\Repositories\Chassis;

use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as ChassisException;
use Kravinskiy\LaravelChassis\Models\ModelInterface;

abstract class AbstractBaseGetRepository extends AbstractBaseRepository
{
    /**
     * @param string $id
     * @return ModelInterface|null
     * @throws CanNotGetEntityException
     * @throws ChassisException
     */
    public function handle(string $id): ?ModelInterface
    {
        try {
            return $this->getModel()::find($id);
        } catch (Exception $exception) {
            throw new CanNotGetEntityException($exception);
        }
    }
}
