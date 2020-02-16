<?php

declare(strict_types=1);

use function DI\get;
use PhpUML\FileCollector;
use PhpUML\FileWriter;
use PhpUML\IFileCollector;
use PhpUML\IWriter;
use PhpUML\UML\Formatter\Formatter;
use PhpUML\UML\Formatter\IFormatter;

return [
    IWriter::class => \DI\autowire(FileWriter::class),
    \PhpUML\UML\IUMLDiagramFactory::class => \DI\autowire(\PhpUML\UML\UmlDiagramFactory::class),
    IFileCollector::class => function (): IFileCollector {
        return new FileCollector();
    },
    IFormatter::class => function (): IFormatter {
        return new Formatter();
    },
    \PhpUML\Command\GenerateCommand::class => \DI\autowire()->constructor(get(\PhpUML\Generator::class)),

    \PhpUML\IApplication::class => \DI\autowire(\PhpUML\Application::class)->constructor(get(\PhpUML\Command\GenerateCommand::class))

];