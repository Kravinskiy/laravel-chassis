<?php

namespace Kravinskiy\LaravelChassis\Http\Responses;

use Kravinskiy\LaravelChassis\Models\StandardResponse\Message\Message;
use Kravinskiy\LaravelChassis\Models\StandardResponse\GoodResponse\GoodResponse as GoodResponseModel;
use Illuminate\Http\JsonResponse;

class GoodResponse
{
    /**
     * @param array $body
     * @param int $statusCode
     * @param string $message
     * @param array $translation
     * @return JsonResponse
     */
    public static function create(
        array $body = [],
        int $statusCode = 200,
        string $message = '',
        array $translation = []
    ): JsonResponse {
        $goodResponse = new GoodResponseModel($body, new Message($message));
        return JsonResponse::create($goodResponse->toArray(), $statusCode);
    }
}