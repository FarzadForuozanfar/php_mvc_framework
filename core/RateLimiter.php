<?php 

namespace Core;

use App\Strategies\SessionStrategy;
use Exception;

class RateLimiter
{
    private static ?self $instance = null;
    private $strategy;

    private function __construct()
    {
        $config = require __DIR__ . '/../config/ratelimiter.php';

        $driver = $config['driver'] ?? 'session';

        switch ($driver) {
            case 'session':
                $this->strategy = new SessionStrategy();
                break;
            // case 'redis':
            //     $this->strategy = new RedisStrategy();
            //     break;
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

    public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool
    {
        return $this->strategy->attempt($key, $maxAttempts, $decayMinutes);
    }
}


?>