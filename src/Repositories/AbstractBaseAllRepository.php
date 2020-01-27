<?php

namespace Kravinskiy\LaravelChassis\Repositories;

use Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotGetEntityException;
use Illuminate\Support\Collection;
use Exception;
use Kravinskiy\LaravelChassis\Exceptions\Exception as ChassisException;

abstract class AbstractBaseAllRepository extends AbstractBaseRepository
{
    /**
     * @return Collection
     * @throws CanNotGetEntityException
     * @throws ChassisException
     */
    public function handle(): Collection
    {
        try {
            return $this->getModel()::all();
        } catch (Exception $exception) {
            throw new CanNotGetEntityException($exception);
        }
    }
}
