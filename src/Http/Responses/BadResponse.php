<?php

namespace Kravinskiy\LaravelChassis\Http\Responses;

use Kravinskiy\LaravelChassis\Models\Reason\ReasonInterface;
use Kravinskiy\LaravelChassis\Models\StandardResponse\BadResponse\BadResponse as BadResponseModel;
use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class BadResponse
{
    /**
     * @param Message|null $message
     * @param int $statusCode
     * @param ReasonInterface|null $reason
     * @param Collection|null $errors
     * @return JsonResponse
     * @throws \Kravinskiy\LaravelChassis\Exceptions\Exception
     */
    public static function create(
        Message $message = null,
        int $statusCode = 500,
        ReasonInterface $reason = null,
        Collection $errors = null
    ): JsonResponse {

        $badResponse = new BadResponseModel(
            $reason,
            $errors,
            $message
        );

        return JsonResponse::create(['error' => $badResponse->toArray()], $statusCode);
    }

    /**
     * @param array $object
     * @return bool
     */
    private static function validateErrorObject(array $object): bool
    {
        return Validator::make($object, [
            'message' => 'required|string',
            'attribute' => 'required|string',
        ])->fails();
    }
}