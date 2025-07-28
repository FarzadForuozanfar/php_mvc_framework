<?php 


namespace App\Strategies;

use App\interfaces\RateLimiterStrategyInterface ;

class SessionStrategy implements RateLimiterStrategyInterface
{
  public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool
{
    session_start(); 

    $attempts = $_SESSION[$key] ?? 0;
    $expiresAt = $_SESSION["{$key}_expires_at"] ?? (time() + ($decayMinutes * 60));

    if ($attempts >= $maxAttempts && time() < $expiresAt) {
        return false;
    }

    if (time() >= $expiresAt) {
        $attempts = 0;
    }

    $_SESSION[$key] = $attempts + 1;
    $_SESSION["{$key}_expires_at"] = $expiresAt;

    return true;
}

}













?>