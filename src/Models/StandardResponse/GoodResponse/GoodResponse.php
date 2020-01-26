<?php

namespace Kravinskiy\LaravelChassis\Models\StandardResponse\GoodResponse;

use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;

class GoodResponse
{
    /**
     * @var array
     */
    protected $body = [];

    /**
     * @var Message
     */
    protected $message;

    /**
     * @param array $body
     * @param Message|null $message
     */
    public function __construct(array $body = [], ?Message $message = null)
    {
        if (empty($message)) {
            $message = new Message();
        }

        $this->message = $message;
        $this->body = $body;
    }

    /**
     * @param array $body
     * @param Message|null $message
     * @return GoodResponse
     */
    public static function create(array $body = [], Message $message = null): GoodResponse
    {
        return new static($body, $message);
    }

    /**
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * @param array $body
     * @return GoodResponse
     */
    public function setBody(array $body): GoodResponse
    {
        $this->body = $body;
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
     * @return GoodResponse
     */
    public function setMessage(Message $message): GoodResponse
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
            'body' => $this->getBody(),
            'message' => $this->getMessage()->toArray(),
        ];
    }
}