<?php

use Core\Application;

require_once __DIR__.'/../vendor/autoload.php';

date_default_timezone_set(config('TIMEZONE'));

$app = new Application();

$app->run();
