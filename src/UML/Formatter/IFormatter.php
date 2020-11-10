<?php declare(strict_types=1);
// @codeCoverageIgnoreStart


namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLDiagram;

interface IFormatter
{
    public function format(UMLDiagram $diagram): string;
}
