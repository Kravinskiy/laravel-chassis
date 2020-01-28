<?php

namespace Kravinskiy\LaravelChassis\Services;

use Kravinskiy\LaravelChassis\Repositories\AbstractBaseAllRepository;
use Illuminate\Support\Collection;

abstract class AbstractBaseAllService extends AbstractBaseService
{
    /**
     * @return Collection
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function handle(): Collection
    {
        /**
         * @var AbstractBaseAllRepository $repository
         */
        $repository = $this->getRepository();
        return $repository->handle();
    }
}
