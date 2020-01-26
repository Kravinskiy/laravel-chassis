<?php

namespace App\Services\Chassis;

use App\Exceptions\Entity\EntityNotFoundException;
use App\Models\Chassis\DatabaseModel;
use App\Repositories\Chassis\AbstractBaseUpdateRepository;

abstract class AbstractBaseUpdateService extends AbstractBaseService
{
    /**
     * @param string $id
     * @param array $data
     * @return DatabaseModel
     * @throws EntityNotFoundException
     * @throws \App\Exceptions\Entity\CanNotGetEntityException
     * @throws \App\Exceptions\Entity\CanNotUpdateEntityException
     * @throws \App\Exceptions\Exception
     */
    public function handle(string $id, array $data) : DatabaseModel
    {
        /** @var AbstractBaseUpdateRepository $repository */
        $repository = $this->getRepository();
        $model = $repository->handle($id, $data);

        if (empty($model)) {
            throw new EntityNotFoundException;
        }

        return $model;
    }
}
