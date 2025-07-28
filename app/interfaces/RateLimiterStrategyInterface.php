<?php



namespace App\interfaces;

interface RateLimiterStrategyInterface
{
    public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool;
}






?>