<?php

namespace App\Services\Chassis;

use App\Exceptions\Entity\EntityNotFoundException;
use App\Models\Chassis\DatabaseModel;
use App\Repositories\Chassis\AbstractBaseGetRepository;

abstract class AbstractBaseGetService extends AbstractBaseService
{
    /**
     * @param string $id
     * @return DatabaseModel
     * @throws EntityNotFoundException
     * @throws \App\Exceptions\Entity\CanNotGetEntityException
     * @throws \App\Exceptions\Exception
     */
    public function handle(string $id): DatabaseModel
    {
        /**
         * @var AbstractBaseGetRepository $repository
         */
        $repository = $this->getRepository();
        $model = $repository->handle($id);

        if (empty($model)) {
            throw new EntityNotFoundException();
        }

        return $model;
    }
}
