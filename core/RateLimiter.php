<?php 

namespace Core;

use App\Strategies\APCuStrategy;
use App\Strategies\RedisStrategy;
use App\Strategies\SessionStrategy;
use Exception;

class RateLimiter
{
    private static ?self $instance = null;
    private $strategy;

    private function __construct()
    {

        $driver = config('RATE_LIMITER_DRIVER') ?? 'session';
        $maxAttempts = config('RATE_LIMITER_MAX_ATTEMPTS') ?? 5;
        $decayMinutes = config('RATE_LIMITER_DECAY_MINUTES') ?? 1;

        switch ($driver) {
            case 'session':
                $this->strategy = new SessionStrategy();
                break;
            case 'redis':
                $this->strategy = new RedisStrategy();
                break;
            case 'apcu':
                $this->strategy = new APCuStrategy();
                break;
            default:
                throw new Exception("Unknown rate limiter driver: $driver");
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function attempt(string $key, ?int $maxAttempts  = null, ?int $decayMinutes = null): bool
    {

        $maxAttempts = $maxAttempts ?? config('MAX_ATTEMPTS');
        $decayMinutes = $decayMinutes ?? config('DECAY_MINUTES');

        return $this->strategy->attempt($key, $maxAttempts, $decayMinutes);
    }
}

