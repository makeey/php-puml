<?php declare(strict_types=1);

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLProperty;

class ClassFormatter
{
    private MethodFormatter $methodFormatter;
    private PropertyFormatter $propertyFormatter;

    public function __construct(MethodFormatter $methodFormatter, PropertyFormatter $propertyFormatter)
    {
        $this->methodFormatter = $methodFormatter;
        $this->propertyFormatter = $propertyFormatter;
    }
    public function format(UMLClass $class): string
    {
        $property = implode("\n    ", array_map(function (UMLProperty $property): string {
            return $this->propertyFormatter->format($property);
        }, $class->properties()));
        $methods = implode("\n    ", array_map(function (UMLMethod $property): string {
            return $this->methodFormatter->format($property);
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
