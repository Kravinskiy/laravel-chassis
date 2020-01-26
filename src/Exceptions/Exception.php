<?php

namespace Kravinskiy\LaravelChassis\Exceptions;

use Kravinskiy\LaravelChassis\Models\Domain\Domain;
use Kravinskiy\LaravelChassis\Models\Domain\DomainInterface;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\Reason\ReasonInterface;
use Kravinskiy\LaravelChassis\Models\StandardResponse\BadResponse\BadResponseError;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Support\Collection;
use Throwable;

class Exception extends \Exception
{

    /**
     * @var ReasonInterface
     */
    protected $reason;

    /**
     * @var Message
     */
    protected $customMessage;

    /**
     * @var BadResponseError[]|Collection
     */
    protected $errors;

    /**
     * Exception constructor.
     * @param Message|null $message
     * @param int $code
     * @param ReasonInterface|null $reason
     * @param Collection|null $errors
     * @param Throwable|null $previous
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function __construct(
        Message $message = null,
        int $code = 500,
        ReasonInterface $reason = null,
        Collection $errors = null,
        Throwable $previous = null
    ) {
        parent::__construct($message ? $message->getBody() : '', $code, $previous);

        if (empty($reason)) {
            $reason = new Reason();
        }

        if (empty($message)) {
            $message = new Message();
        }

        if (empty($errors)) {
            $errors = new Collection();
        }

        $this->errors = $errors;
        $this->reason = $reason;
        $this->customMessage = $message;
    }

    /**
     * @return ReasonInterface
     */
    public function getReason(): ReasonInterface
    {
        return $this->reason;
    }

    /**
     * @param ReasonInterface $reason
     * @return Exception
     */
    public function setReason(ReasonInterface $reason): Exception
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @return Message
     */
    public function getCustomMessage(): Message
    {
        return $this->customMessage;
    }

    /**
     * @param Message $customMessage
     * @return Exception
     */
    public function setCustomMessage(Message $customMessage): Exception
    {
        $this->customMessage = $customMessage;
        return $this;
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
     * @return Exception
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        return $this;
    }


}