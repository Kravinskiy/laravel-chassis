<?php

namespace Kravinskiy\LaravelChassis\Services;

use Kravinskiy\LaravelChassis\Exceptions\Entity\EntityNotFoundException;
use Kravinskiy\LaravelChassis\Models\ModelInterface;
use Kravinskiy\LaravelChassis\Repositories\AbstractBaseGetRepository;

abstract class AbstractBaseGetService extends AbstractBaseService
{
    /**
     * @param string $id
     * @return ModelInterface
     * @throws EntityNotFoundException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function handle(string $id): ModelInterface
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
