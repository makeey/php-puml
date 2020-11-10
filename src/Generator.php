<?php declare(strict_types=1);

namespace PhpUML;

use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\SourceParser;
use PhpUML\Parser\TransformMiddleware\IFileTransform;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Formatter\IFormatter;
use PhpUML\UML\IUMLDiagramFactory;

class Generator
{
    private IWriter $writer;
    private IFileCollector $fileCollector;
    private IUMLDiagramFactory $umlFactory;
    private SourceParser $sourceParser;
    private IFormatter $formatter;
    private IFileTransform $fileTransform;

    public function __construct(
        IWriter $writer,
        IFileCollector $fileCollector,
        IUMLDiagramFactory $umlFactory,
        SourceParser $sourceParser,
        IFormatter $formatter,
        IFileTransform $fileTransform
    ) {
        $this->writer = $writer;
        $this->fileCollector = $fileCollector;
        $this->umlFactory = $umlFactory;
        $this->sourceParser = $sourceParser;
        $this->formatter = $formatter;
        $this->fileTransform = $fileTransform;
    }


    public function generate(string $path, string $output): void
    {
        $this->writer->setOutput($output);
        $files = $this->fileCollector->collect($path);
        $parser = $this->sourceParser;
        $diagrams = array_values(array_map(function (PhpFile $file): UMLDiagram {
            return $this->umlFactory->buildDiagram($file);
        }, array_map(function (string $filePath) use ($parser): PhpFile {
            $fileContent = file_get_contents($filePath);
            return $this->fileTransform->transform($parser($fileContent !== false ? $fileContent : ''));
        }, $files)));
        /** @var UMLDiagram $diagram */
        $diagram = new UMLDiagram([]);
        for ($i = 0; $i < count($diagrams); $i++) {
            $diagram->mergeDiagram($diagrams[$i]);
        }
        $this->writer->write($this->formatter->format($diagram));
    }
}
