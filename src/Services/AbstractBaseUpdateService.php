<?php

namespace Kravinskiy\LaravelChassis\Services;

use Kravinskiy\LaravelChassis\Exceptions\Entity\EntityNotFoundException;
use Kravinskiy\LaravelChassis\Models\Model;
use Kravinskiy\LaravelChassis\Repositories\AbstractBaseUpdateRepository;

abstract class AbstractBaseUpdateService extends AbstractBaseService
{
    /**
     * @param string $id
     * @param array $data
     * @return Model
     * @throws EntityNotFoundException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotUpdateEntityException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function handle(string $id, array $data) : Model
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
