<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLProperty;

class ClassFormatter
{
    public static function format(UMLClass $class): string
    {
        $property = implode("\n    ", array_map(static function (UMLProperty $property): string {
            return PropertyFormatter::format($property);
        }, $class->properties()));
        $methods = implode("\n    ", array_map(static function (UMLMethod $property): string {
            return MethodFormatter::format($property);
        }, $class->methods()));

        return <<<EOT
class {$class->className()}
{
    {$property}
    --
    {$methods}
}
EOT;
    }


}