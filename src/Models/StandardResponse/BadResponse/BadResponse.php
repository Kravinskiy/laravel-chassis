<?php

namespace Kravinskiy\LaravelChassis\Models\StandardResponse\BadResponse;

use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\Reason\ReasonInterface;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Support\Collection;

class BadResponse
{
    /**
     * @var Reason
     */
    protected $reason;

    /**
     * @var BadResponseError[]|Collection
     */
    protected $errors;

    /**
     * @var Message
     */
    protected $message;

    /**
     * BadResponse constructor.
     * @param ReasonInterface|null $reason
     * @param Collection|null $errors
     * @param Message|null $message
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function __construct(
        ?ReasonInterface $reason = null,
        ?Collection $errors = null,
        ?Message $message = null
    ) {

        if (empty($reason)) {
            $reason = new Reason;
        }

        if (empty($errors)) {
            $errors = new Collection;
        }

        if (empty($message)) {
            $message = new Message;
        }

        $this->reason = $reason;
        $this->errors = $errors;
        $this->message = $message;
    }

    /**
     * @return Reason
     */
    public function getReason(): Reason
    {
        return $this->reason;
    }

    /**
     * @param Reason $reason
     */
    public function setReason(Reason $reason): void
    {
        $this->reason = $reason;
    }

    /**
     * @return BadResponseError[]|Collection
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param BadResponseError[]|Collection $errors
     */
    public function setErrors($errors): void
    {
        $this->errors = $errors;
    }

    /**
     * @return Message
     */
    public function getMessage(): Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message): void
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'reason' => $this->getReason()->getReason(),
            'message' => $this->getMessage()->toArray(),
            'errors' => $this->getErrors()->map->toArray()
        ];
    }
}