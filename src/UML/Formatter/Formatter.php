<?php


namespace PhpUML\UML\Formatter;


use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLPackage;

class Formatter implements IFormatter
{
    private $output = "";

    public function format(UMLDiagram $diagram): string
    {
        $this->output = "@startuml " . PHP_EOL;
        $this->output .= $this->formatUmlDiagram($diagram);
        $this->output .= $this->buildRelations($diagram);
        $this->output .= PHP_EOL . "@enduml";
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

    private function buildRelations(UMLDiagram $diagram): string
    {
        $classes = [];
        array_map(function (UMLPackage $package) use (&$classes) {
            self::collectAllClasses($package, $classes);
        }, $diagram->packages());
        $string = "";
        /** @var UMLClass $class */
        foreach ($classes as $class) {
            if($class->extends() !== null) {
                $string .= "{$class->className()} --> {$class->extends()}\n";
            }
            if($class->implements() !== []) {
                foreach ($class->implements() as $interface) {
                    $string .= "{$class->className()} --> {$interface}\n";
                }
            }
        }
        return $string;
    }

    private static function collectAllClasses(UMLPackage $package, &$classes = [])
    {
        if ($package->packages() === []) {
            return $classes = array_merge($classes, $package->classes());
        }
        array_map(function (UMLPackage $package) use (&$classes) {
            return self::collectAllClasses($package, $classes);
        }, $package->packages());
        return $classes = array_merge($classes, $package->classes());
    }
}