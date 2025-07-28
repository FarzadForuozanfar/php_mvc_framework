<?php 


namespace App\RateLimiter;

use App\interfaces\RateLimiterStrategyInterface;

class RateLimiter
{
    protected RateLimiterStrategyInterface $strategy;

    public function __construct(RateLimiterStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool
    {
        return $this->strategy->attempt($key, $maxAttempts, $decayMinutes);
    }
}






?>