<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLMethod;

class InterfaceFormatter
{
    private MethodFormatter $methodFormatter;

    public function __construct(MethodFormatter $methodFormatter)
    {
        $this->methodFormatter = $methodFormatter;
    }

    public function format(UMLInterface $interface): string
    {
        $methods = implode("\n    ", array_map(function (UMLMethod $property): string {
            return $this->methodFormatter->format($property);
        }, $interface->methods()));
        return "interface {$interface->name()} \n{\n\t{$methods}\n}\n";
    }
}
