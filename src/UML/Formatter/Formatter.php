<?php


namespace PhpUML\UML\Formatter;


use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLPackage;

class Formatter implements IFormatter
{
    private $output = "";

    public function format(UMLDiagram $diagram): string
    {
        $this->output = "@startuml ". PHP_EOL;
        $this->output .= $this->formatUmlDiagram($diagram);
        $this->output .= PHP_EOL. "@enduml";
        return $this->output;
    }
    private function formatUmlDiagram(UMLDiagram $diagram): string
    {
        return implode(" ", array_map(
            function (UMLPackage $package): string {
               return $this->formatUmlPackage($package);
            }, $diagram->packages()));
    }

    public function formatUmlPackage(UMLPackage $package): string
    {
       return PackageFormatter::format($package);
    }

}