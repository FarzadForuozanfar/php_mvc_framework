<?php

namespace App\Strategies;

use Core\Log;
use App\interfaces\RateLimiterStrategyInterface;

class RedisStrategy implements RateLimiterStrategyInterface
{
    protected $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect(config('REDIS_HOST'), config('REDIS_PORT'));
    }

    public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool
    {
        $redisKey = 'rate_limit:' . $key;
        $attempts = (int) $this->redis->get($redisKey);
        Log::add('Redis attempts: ' . $attempts, Log::INFO_TYPE);
        if ($attempts >= $maxAttempts) {
            return false;
        }
        if ($attempts === 0) {
            $this->redis->set($redisKey, 1, ['ex' => $decayMinutes * 60]);
        } else {
            $this->redis->incr($redisKey);
        }
        return true;
    }
} 