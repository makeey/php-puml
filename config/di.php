<?php

declare(strict_types=1);

use function DI\autowire;
use function DI\get;
use PhpUML\Application;
use PhpUML\Command\GenerateCommand;
use PhpUML\FileCollector;
use PhpUML\FileWriter;
use PhpUML\IApplication;
use PhpUML\IFileCollector;
use PhpUML\IWriter;
use PhpUML\Parser\TransformMiddleware\IFileTransform;
use PhpUML\Parser\TransformMiddleware\NamespaceTransform;
use PhpUML\UML\Formatter\Formatter;
use PhpUML\UML\Formatter\IFormatter;
use PhpUML\UML\IUMLDiagramFactory;
use PhpUML\UML\UmlDiagramFactory;

return [
    IWriter::class => autowire(FileWriter::class),
    IUMLDiagramFactory::class => autowire(UmlDiagramFactory::class),
    IFileCollector::class => static function (): IFileCollector {
        return new FileCollector();
    },
    IFormatter::class => autowire(Formatter::class),
    GenerateCommand::class => autowire()->constructor(get(\PhpUML\Generator::class)),

    IApplication::class => autowire(Application::class)->constructor(get(GenerateCommand::class)),
    IFileTransform::class => autowire(NamespaceTransform::class),
];
