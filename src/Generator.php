<?php

namespace PhpUML;

use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\SourceParser;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Formatter\IFormatter;
use PhpUML\UML\IUMLDiagramFactory;
use PhpUML\UML\UmlDiagramFactory;

class Generator
{
    /** @var IWriter * */
    private $writer;
    /** @var IFileCollector * */
    private $fileCollector;
    /** @var UmlDiagramFactory * */
    private $umlFactory;
    /** @var SourceParser * */
    private $sourceParser;
    /** @var IFormatter * */
    private $formatter;

    public function __construct(
        IWriter $writer,
        IFileCollector $fileCollector,
        IUMLDiagramFactory $umlFactory,
        SourceParser $sourceParser,
        IFormatter $formatter
    )
    {
        $this->writer = $writer;
        $this->fileCollector = $fileCollector;
        $this->umlFactory = $umlFactory;
        $this->sourceParser = $sourceParser;
        $this->formatter = $formatter;
    }


    public function generate(string $path, string $output)
    {
        $this->writer->setOutput($output);
        $files = $this->fileCollector->collect($path);
        $parser = $this->sourceParser;
        $diagrams = array_map(function (PhpFile $file): UMLDiagram {
            return $this->umlFactory->buildDiagram($file);
        }, array_map(function (string $filePath) use ($parser): PhpFile {
            return $parser(file_get_contents($filePath));
        }, $files));
        /** @var UMLDiagram $diagram */
        $diagram = $diagrams[0];
        for ($i = 1; $i < count($diagrams); $i++) {
            $diagram->mergeDiagram($diagrams[$i]);
        }
        $this->writer->write($this->formatter->format($diagram));
    }
}