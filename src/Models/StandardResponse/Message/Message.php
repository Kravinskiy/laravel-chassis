<?php

namespace Kravinskiy\LaravelChassis\Models\StandardResponse\Message;

class Message
{
    /**
     * @var string
     */
    protected $body = '';

    /**
     * Message constructor.
     * @param string $body
     */
    public function __construct(string $body = '')
    {
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return Message
     */
    public function setBody(string $body): Message
    {
        $this->body = $body;
        return $this;
    }

    public static function fromString(string $message)
    {
        return new static($message);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'body' => $this->getBody()
        ];
    }
}