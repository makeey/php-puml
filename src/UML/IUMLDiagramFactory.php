<?php declare(strict_types=1);
// @codeCoverageIgnoreStart

namespace PhpUML\UML;

use PhpUML\Parser\Entity\PhpFile;
use PhpUML\UML\Entity\UMLDiagram;

interface IUMLDiagramFactory
{
    public function buildDiagram(PhpFile $file): UMLDiagram;
}
