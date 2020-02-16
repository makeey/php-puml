<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

if (! isset($GLOBALS['container'])) {
    $builder = new DI\ContainerBuilder();
    $builder->useAutowiring(true);
    $builder->addDefinitions(require_once __DIR__ . '/config/di.php');
    $GLOBALS['container'] = $builder->build();
}

return $GLOBALS['container'];