<?php

namespace Kravinskiy\LaravelChassis\Models\StandardResponse\BadResponse;

use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;

class BadResponseError
{
    /**
     * @var string
     */
    private $attribute = '';

    /**
     * @var Message
     */
    private $message;

    public function __construct(string $attribute = '', Message $message = null)
    {
        if (empty($message)) {
            $message = new Message;
        }

        $this->attribute = $attribute;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }

    /**
     * @param string $attribute
     * @return BadResponseError
     */
    public function setAttribute(string $attribute): BadResponseError
    {
        $this->attribute = $attribute;
        return $this;
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
     * @return BadResponseError
     */
    public function setMessage(Message $message): BadResponseError
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'attribute' => $this->getAttribute(),
            'message' => $this->getMessage()->toArray()
        ];
    }

}