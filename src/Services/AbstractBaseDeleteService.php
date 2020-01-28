<?php

namespace Kravinskiy\LaravelChassis\Services;

use Kravinskiy\LaravelChassis\Repositories\AbstractBaseDeleteRepository;

abstract class AbstractBaseDeleteService extends AbstractBaseService
{
    /**
     * @param string $id
     * @return int
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Entity\CanNotDeleteEntityException
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function handle(string $id)
    {
        /** @var AbstractBaseDeleteRepository $repository */
        $repository = $this->getRepository();
        return $repository->handle($id);
    }
}
