<?php

use PhpUML\IApplication;

$container = require_once __DIR__ .'/../bootstrap.php';

$container->call(static function (IApplication $application) {
    $application->run();
});