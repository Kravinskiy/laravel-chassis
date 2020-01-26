<?php

namespace Kravinskiy\LaravelChassis\Models\Reason;

use Kravinskiy\LaravelChassis\Exceptions\Exception;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Http\JsonResponse;

abstract class AbstractReason implements ReasonInterface
{

    const UNKNOWN_REASON = 'REASON_NOT_SPECIFIED';

    protected const REASONS = [];

    /**
     * @var string
     */
    protected $reason;

    /**
     * @param string $reason
     * @throws Exception
     */
    public function __construct(string $reason = '')
    {
        if (empty($reason)) {
            $reason = self::UNKNOWN_REASON;
        }
        $this->reason = $reason;

        $this->validate();
    }

    /**
     * @return array
     */
    public static function all(): array
    {
        return static::REASONS;
    }

    /**
     * @param string $reason
     * @return bool
     */
    public static function verify(string $reason): bool
    {
        return in_array($reason, static::all());
    }

    /**
     * @param string $reason
     * @return AbstractReason
     * @throws Exception
     */
    public static function fromString(string $reason): ReasonInterface
    {
        return new static($reason);
    }

    /**
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * @param string $reason
     * @return AbstractReason
     */
    public function setReason(string $reason): AbstractReason
    {
        $this->reason = $reason;
        return $this;
    }

    /**
     * @throws Exception
     */
    public function validate(): void
    {
        if (!static::verify($this->getReason())) {
            throw new Exception(
                new Message('Invalid Reason'),
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                static::fromString(Reason::INVALID_REASON)
            );
        }
    }
}