<?php

namespace Kravinskiy\LaravelChassis\Services;

use Kravinskiy\LaravelChassis\Repositories\AbstractBaseRepository;

/**
 * @method handle()
 */
abstract class AbstractBaseService
{
    /**
     * @var AbstractBaseRepository
     */
    protected $repository;

    /**
     * @param AbstractBaseRepository $repository
     */
    protected function setRepository(AbstractBaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return AbstractBaseRepository
     */
    protected function getRepository(): AbstractBaseRepository
    {
        return $this->repository;
    }
}
