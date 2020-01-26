<?php

namespace Kravinskiy\LaravelChassis\Models\Reason;

/**
 * A class to contain all the "reasons" of the application
 * Primarily used for error object generation
 */
class Reason extends AbstractReason
{
    const INVALID_DOMAIN = 'INVALID_DOMAIN';
    const INVALID_REASON = 'INVALID_REASON';
    const VALIDATION_ERROR = 'VALIDATION_ERROR';
    const TOKEN_NOT_FOUND = 'TOKEN_NOT_FOUND';

    const REASONS = [
        self::INVALID_DOMAIN,
        self::INVALID_REASON,
        self::UNKNOWN_REASON,
        self::VALIDATION_ERROR,
        self::TOKEN_NOT_FOUND,
    ];

    /**
     * @return array
     */
    public static function all(): array
    {
        return array_merge(
            self::REASONS,
            HttpReason::all()
        );
    }
}