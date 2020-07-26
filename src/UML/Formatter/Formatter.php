<?php


namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLNamespace;

class Formatter implements IFormatter
{
    private NamespaceFormatter $namespaceFormatter;
    private RelationFormatter $relationFormatter;

    public function __construct(NamespaceFormatter $namespaceFormatter, RelationFormatter $relationFormatter)
    {
        $this->namespaceFormatter = $namespaceFormatter;
        $this->relationFormatter = $relationFormatter;
    }

    public function format(UMLDiagram $diagram): string
    {
        $output = "@startuml " . PHP_EOL;
        $output .= $this->formatUmlDiagram($diagram);
        $output .= $this->relationFormatter->format($diagram);
        $output .= PHP_EOL . "@enduml";
        return $output;
    }

    private function formatUmlDiagram(UMLDiagram $diagram): string
    {
        return implode(" ", array_map(
            function (UMLNamespace $package): string {
                return $this->namespaceFormatter->format($package);
            },
            $diagram->namespaces()
        ));
    }
}
