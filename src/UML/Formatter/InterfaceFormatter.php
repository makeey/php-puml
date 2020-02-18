<?php


namespace PhpUML\UML\Formatter;


use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLMethod;

class InterfaceFormatter
{
    public static function format(UMLInterface $interface): string
    {
        $methods = implode("\n    ", array_map(static function (UMLMethod $property): string {
            return MethodFormatter::format($property);
        }, $interface->methods()));
        return "interface {$interface->name()} \n{\n\t{$methods}\n}\n";
    }
}