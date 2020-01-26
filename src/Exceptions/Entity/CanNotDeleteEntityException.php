<?php

namespace Kravinskiy\LaravelChassis\Exceptions\Entity;

use Kravinskiy\LaravelChassis\Exceptions\Exception as StandardException;
use Kravinskiy\LaravelChassis\Models\Reason\EntityReason;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;

class CanNotDeleteEntityException extends StandardException
{
    /**
     * CanNotDeleteEntityException constructor.
     * @param \Exception $exception
     * @throws StandardException
     */
    public function __construct(\Exception $exception)
    {
        $message = Message::fromString($exception->getMessage());
        parent::__construct($message);

        $reason = Reason::fromString(EntityReason::ENTITY_DELETE_FAILURE);
        $this->reason = $reason;
    }
}