<?php

namespace Kravinskiy\LaravelChassis\Models\Reason;

class EntityReason extends AbstractReason
{
    const ENTITY_CREATE_FAILURE = 'ENTITY_CREATE_FAILURE';
    const ENTITY_DELETE_FAILURE = 'ENTITY_DELETE_FAILURE';
    const ENTITY_GET_FAILURE = 'ENTITY_GET_FAILURE';
    const ENTITY_UPDATE_FAILURE = 'ENTITY_UPDATE_FAILURE';
    const ENTITY_NOT_FOUND = 'ENTITY_NOT_FOUND';

    const REASONS = [
        self::ENTITY_CREATE_FAILURE,
        self::ENTITY_DELETE_FAILURE,
        self::ENTITY_GET_FAILURE,
        self::ENTITY_UPDATE_FAILURE,
        self::ENTITY_NOT_FOUND
    ];
}