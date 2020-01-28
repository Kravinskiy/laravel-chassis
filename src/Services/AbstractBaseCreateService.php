<?php

namespace Kravinskiy\LaravelChassis\Services;

use Kravinskiy\LaravelChassis\Repositories\AbstractBaseCreateRepository;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractBaseCreateService extends AbstractBaseService
{

    /**
     * @param array $data
     * @return Model
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotCreateEntityException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function handle(array $data): Model
    {
        /**
         * @var AbstractBaseCreateRepository $repository
         */
        $repository = $this->getRepository();
        return $repository->handle($data);
    }
}
