<?php declare(strict_types=1);

namespace PhpUML\Tests;

use PhpUML\Generator;
use PhpUML\IFileCollector;
use PhpUML\IWriter;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\SourceParser;
use PhpUML\Parser\TransformMiddleware\IFileTransform;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Formatter\IFormatter;
use PhpUML\UML\IUMLDiagramFactory;
use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        $path = 'src/';
        $output = 'test.puml';
        $collectedFiles = [  __DIR__.'/data/Foo.php'];

        $writerMock = $this->createMock(IWriter::class);
        $writerMock->expects($this->once())
            ->method('setOutput')
            ->with($output);

        $fileCollectorMock = $this->createMock(IFileCollector::class);
        $fileCollectorMock->expects($this->once())
            ->method("collect")
            ->with($path)
            ->willReturn($collectedFiles);

        $sourceParserMock = $this->createMock(SourceParser::class);
        $sourceParserMock->expects($this->once())
            ->method('__invoke')
            ->willReturn($file = new PhpFile());
        $fileTransformMock = $this->createMock(IFileTransform::class);
        $fileTransformMock->expects($this->once())
            ->method('transform')
            ->willReturn($file);
        $umlDiagramFactory = $this->createMock(IUMLDiagramFactory::class);
        $umlDiagramFactory->expects($this->once())
            ->method('buildDiagram')
            ->willReturn(new UMLDiagram([]));
        $formatterMock = $this->createMock(IFormatter::class);
        $formatterMock->expects($this->once())
            ->method('format')
            ->with(new UMLDiagram([]))
            ->willReturn($formattedString = "formattersrting");
        $writerMock->expects($this->once())
            ->method('write')
            ->with($formattedString);

        $generator = new Generator(
            $writerMock,
            $fileCollectorMock,
            $umlDiagramFactory,
            $sourceParserMock,
            $formatterMock,
            $fileTransformMock
        );

        $generator->generate('src/', 'test.puml');
    }
}
