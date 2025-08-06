<?php


define("X_XSS_Protection", header('X-XSS-Protection: 1; mode=block'));
define("X_Content_Type_Options", header('X-Content-Type-Options: nosniff'));
define("X_Frame_Options", header('X-Frame-Options: DENY'));
define("Referrer_Policy", header('Referrer-Policy: strict-origin-when-cross-origin'));
define("Content_Security_Policy", header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://cdn.jsdelivr.net; img-src 'self' data: https:; font-src 'self' https://cdn.jsdelivr.net;"));