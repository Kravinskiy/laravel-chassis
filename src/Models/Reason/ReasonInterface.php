<?php

namespace Kravinskiy\LaravelChassis\Models\Reason;

interface ReasonInterface
{
    public static function verify(string $reason): bool;
    public static function all(): array;
    public function getReason(): string;
    public function validate(): void;
}