<?php

namespace Kravinskiy\LaravelChassis\Exceptions;

use Kravinskiy\LaravelChassis\Models\Reason\Reason;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class ValidationException extends Exception
{

    /**
     * ValidationException constructor.
     * @param Collection|null $validationErrors
     * @throws Exception
     */
    public function __construct(
        Collection $validationErrors = null
    ) {
        $reason = Reason::fromString(Reason::VALIDATION_ERROR);

        parent::__construct(
            new Message('Validation error'),
            JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
            $reason,
            $validationErrors
        );
    }

}