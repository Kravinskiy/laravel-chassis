<?php

namespace Kravinskiy\LaravelChassis\Exceptions\HttpResponse;

use Kravinskiy\LaravelChassis\Exceptions\Exception;
use Kravinskiy\LaravelChassis\Models\Reason\HttpReason;
use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Http\JsonResponse;

class ForbiddenException extends Exception
{
    /**
     * ForbiddenException constructor.
     * @param Message|null $message
     * @throws Exception
     */
    public function __construct(
        Message $message = null
    ) {
        $reason = Reason::fromString(HttpReason::FORBIDDEN);

        parent::__construct(
            $message,
            JsonResponse::HTTP_FORBIDDEN,
            $reason
        );
    }
}