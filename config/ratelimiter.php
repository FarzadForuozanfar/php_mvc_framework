<?php


define("DRIVER", env('RATE_LIMITER_DRIVER', 'session'));
define("MAX_ATTEMPTS", 50);
define("DECAY_MINUTES", 1);
