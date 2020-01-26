<?php

namespace App\Services\Chassis;

use App\Repositories\Chassis\AbstractBaseAllRepository;
use Illuminate\Support\Collection;

abstract class AbstractBaseAllService extends AbstractBaseService
{
    /**
     * @return Collection
     * @throws \App\Exceptions\Entity\CanNotGetEntityException
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
