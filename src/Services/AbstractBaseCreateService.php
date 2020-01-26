<?php

namespace App\Services\Chassis;

use App\Repositories\Chassis\AbstractBaseCreateRepository;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractBaseCreateService extends AbstractBaseService
{
    /**
     * @param array $data
     * @return Model
     * @throws \App\Exceptions\Entity\CanNotCreateEntityException
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
