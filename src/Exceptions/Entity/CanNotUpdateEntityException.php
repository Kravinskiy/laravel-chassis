<?php

namespace Kravinskiy\LaravelChassis\Exceptions\Entity;

use Kravinskiy\LaravelChassis\Exceptions\Exception as StandardException;
use Kravinskiy\LaravelChassis\Models\Reason\EntityReason;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;

class CanNotUpdateEntityException extends StandardException
{
    /**
     * CanNotUpdateEntityException constructor.
     * @param \Exception $exception
     * @throws StandardException
     */
    public function __construct(\Exception $exception)
    {
        $message = Message::fromString($exception->getMessage());
        parent::__construct($message);

        $reason = Reason::fromString(EntityReason::ENTITY_UPDATE_FAILURE);
        $this->reason = $reason;
    }
}