<?php

namespace Kravinskiy\LaravelChassis\Exceptions\Entity;


use Kravinskiy\LaravelChassis\Exceptions\Exception as StandardException;
use Kravinskiy\LaravelChassis\Models\Reason\EntityReason;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;

class CanNotCreateEntityException extends StandardException
{
    /**
     * CanNotCreateEntityException constructor.
     * @param \Exception $exception
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function __construct(\Exception $exception)
    {
        $message = Message::fromString($exception->getMessage());
        parent::__construct($message);
        $this->code = $exception->getCode();

        $reason = Reason::fromString(EntityReason::ENTITY_CREATE_FAILURE);
        $this->reason = $reason;
    }
}