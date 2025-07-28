<?php 


namespace App\Strategies;

use App\interfaces\RateLimiterStrategyInterface ;
use Core\Log;

class SessionStrategy implements RateLimiterStrategyInterface
{
  public function attempt(string $key, int $maxAttempts, int $decayMinutes): bool
{
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

    $attempts = $_SESSION[$key] ?? 0;
    $expiresAt = $_SESSION["{$key}_expires_at"] ?? (time() + ($decayMinutes * 60));
Log::add($attempts , Log::INFO_TYPE);
    if ($attempts >= $maxAttempts && time() < $expiresAt) {
        return false;
    }

    if (time() >= $expiresAt) {
        $attempts = 0;
        $expiresAt = time() + ($decayMinutes * 60); // این خط را اضافه کن
    }

    $_SESSION[$key] = $attempts + 1;
    $_SESSION["{$key}_expires_at"] = $expiresAt;

    return true;
}

}













?>