<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLNamespace;

class RelationFormatter
{
    public function format(UMLDiagram $diagram): string
    {
        $classes = [];
        array_map(function (UMLNamespace $package) use (&$classes): void {
            $this->collectAllClasses($package, $classes);
        }, $diagram->namespaces());
        $string = "\n";
        /** @var UMLClass $class */
        foreach ($classes as $class) {
            $className = str_replace("\\\\", ".", $class->namespace() !== null ?
                $class->namespace() . "." . $class->className():
                $class->className());
            if ($class->extends() !== null) {
                $extends = str_replace("\\\\", ".", $class->extends());
                $string .= "{$className} --> {$extends}\n";
            }
            if ($class->implements() !== []) {
                foreach ($class->implements() as $interface) {
                    $interface = str_replace("\\\\", ".", $interface);
                    $string .= "{$className} --> {$interface}\n";
                }
            }
        }
        return $string;
    }

    /**
     * @param UMLNamespace $package
     * @param UMLClass[] $classes
     * @return UMLClass[]
     */
    private function collectAllClasses(UMLNamespace $package, &$classes = []): array
    {
        if ($package->namespaces() === []) {
            return $classes = array_merge($classes, $package->classes());
        }
        array_map(function (UMLNamespace $package) use (&$classes): array {
            return $this->collectAllClasses($package, $classes);
        }, $package->namespaces());
        return $classes = array_merge($classes, $package->classes());
    }
}
