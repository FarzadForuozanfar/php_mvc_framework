<?php

namespace App\Strategies;

use App\interfaces\RateLimiterStrategyInterface;
use Core\Log;
use function apcu_fetch;
use function apcu_store;
use function apcu_inc;

class APCuStrategy implements RateLimiterStrategyInterface
{
    public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool
    {
        $apcuKey = 'rate_limit_' . $key;
        $attempts = (int) apcu_fetch($apcuKey);
        Log::add('APCu attempts: ' . $attempts, Log::INFO_TYPE);
        if ($attempts >= $maxAttempts) {
            return false;
        }
        if ($attempts === 0) {
            apcu_store($apcuKey, 1, $decayMinutes * 60);
        } else {
            apcu_inc($apcuKey);
        }
        return true;
    }
} 