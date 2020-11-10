<?php declare(strict_types=1);

use PhpUML\IApplication;

$container = require __DIR__ .'/../bootstrap.php';

$container->call(static function (IApplication $application) {
    $application->run();
});
