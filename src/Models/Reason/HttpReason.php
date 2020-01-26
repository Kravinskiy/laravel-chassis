<?php

namespace Kravinskiy\LaravelChassis\Models\Reason;

class HttpReason extends AbstractReason
{
    const UNAUTHORIZED = 'UNAUTHORIZED';
    const METHOD_NOT_ALLOWED = 'METHOD_NOT_ALLOWED';
    const INTERNAL_SERVER_ERROR = 'INTERNAL_SERVER_ERROR';
    const NOT_FOUND = 'NOT_FOUND';
    const FORBIDDEN = 'FORBIDDEN';
    const TOO_MANY_REQUESTS = 'TOO_MANY_REQUESTS';
    const BAD_REQUEST = 'BAD_REQUEST';

    const REASONS = [
        self::UNAUTHORIZED,
        self::METHOD_NOT_ALLOWED,
        self::INTERNAL_SERVER_ERROR,
        self::NOT_FOUND,
        self::FORBIDDEN,
        self::TOO_MANY_REQUESTS,
        self::BAD_REQUEST
    ];
}