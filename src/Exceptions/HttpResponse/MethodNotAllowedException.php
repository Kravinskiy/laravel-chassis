<?php

namespace Kravinskiy\LaravelChassis\Exceptions\HttpResponse;


use Kravinskiy\LaravelChassis\Exceptions\Exception;
use Kravinskiy\LaravelChassis\Models\Reason\HttpReason;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Http\JsonResponse;

class MethodNotAllowedException extends Exception
{
    /**
     * MethodNotAllowedException constructor.
     * @param Message|null $message
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public function __construct(
        Message $message = null
    ) {
        $reason = Reason::fromString(HttpReason::METHOD_NOT_ALLOWED);

        parent::__construct(
            $message,
            JsonResponse::HTTP_FORBIDDEN,
            $reason
        );
    }
}