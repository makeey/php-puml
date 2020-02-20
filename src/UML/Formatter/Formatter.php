<?php


namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLNamespace;

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
            function (UMLNamespace $package): string {
                return $this->formatUmlPackage($package);
            },
            $diagram->packages()
        ));
    }

    public function formatUmlPackage(UMLNamespace $package): string
    {
        return NamespaceFormatter::format($package);
    }

    private function buildRelations(UMLDiagram $diagram): string
    {
        $classes = [];
        array_map(function (UMLNamespace $package) use (&$classes) {
            self::collectAllClasses($package, $classes);
        }, $diagram->packages());
        $string = "";
        /** @var UMLClass $class */
        foreach ($classes as $class) {
            $className = str_replace("\\\\", ".", $class->namespace() . "." . $class->className());
            if ($class->extends() !== null) {
                $extends = str_replace("\\\\", ".", $class->extends());
                $string .= "{$className} --> {$extends}\n";
            }
            if ($class->implements() !== []) {
                foreach ($class->implements() as $interface) {
                    $interface =  str_replace("\\\\", ".", $interface);
                    $string .= "{$className} --> {$interface}\n";
                }
            }
        }
        return $string;
    }

    private static function collectAllClasses(UMLNamespace $package, &$classes = [])
    {
        if ($package->namespaces() === []) {
            return $classes = array_merge($classes, $package->classes());
        }
        array_map(function (UMLNamespace $package) use (&$classes) {
            return self::collectAllClasses($package, $classes);
        }, $package->namespaces());
        return $classes = array_merge($classes, $package->classes());
    }
}
