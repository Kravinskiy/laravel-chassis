<?php

namespace App\Services\Chassis;

use App\Repositories\Chassis\AbstractBaseDeleteRepository;

abstract class AbstractBaseDeleteService extends AbstractBaseService
{
    /**
     * @param string $id
     * @return int
     * @throws \App\Exceptions\Entity\CanNotDeleteEntityException
     */
    public function handle(string $id)
    {
        /** @var AbstractBaseDeleteRepository $repository */
        $repository = $this->getRepository();
        return $repository->handle($id);
    }
}
