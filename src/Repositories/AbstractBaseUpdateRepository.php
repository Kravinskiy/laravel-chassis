<?php

namespace Kravinskiy\LaravelChassis\Repositories;

use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException;
use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotUpdateEntityException;
use Kravinskiy\LaravelChassis\Models\Model;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as ChassisException;

abstract class AbstractBaseUpdateRepository extends AbstractBaseRepository
{
    /**
     * @param string $id
     * @param array $data
     * @return DatabaseModel|null
     * @throws CanNotGetEntityException
     * @throws CanNotUpdateEntityException
     * @throws ChassisException
     */
    public function handle(string $id, array $data): ?Model
    {
        try {
            $foundModel = $this->getModel()::find($id);

            if (empty($foundModel)) {
                return null;
            }
        } catch (Exception $exception) {
            throw new CanNotGetEntityException($exception);
        }

        try {
            $foundModel->update($data);
        } catch (Exception $exception) {
            throw new CanNotUpdateEntityException($exception);
        }

        return $foundModel;
    }
}
