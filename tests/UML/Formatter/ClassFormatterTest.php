<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLProperty;
use PhpUML\UML\Formatter\ClassFormatter;
use PHPUnit\Framework\TestCase;

class ClassFormatterTest extends TestCase
{

    public function testFormat()
    {
        $properties  = [
            new UMLProperty("bar", "private", "float")
        ];
        $methods = [
            new UMLMethod("baz")
        ];

        $class = new UMLClass("Foo", $methods, $properties);

        $expectedString = <<<EOT
class {$class->className()}
{
    - bar: float
    --
    baz()
}
EOT;
        $this->assertEquals($expectedString, ClassFormatter::format($class));

        $properties  = [
            new UMLProperty("bar", "private", "float"),
              new UMLProperty("baq", "public", "float")
        ];
        $methods = [
            new UMLMethod("baz"),
            new UMLMethod("oof")
        ];

        $class = new UMLClass("Foo", $methods, $properties);

        $expectedString = <<<EOT
class {$class->className()}
{
    - bar: float
    + baq: float
    --
    baz()
    oof()
}
EOT;
        $this->assertEquals($expectedString, ClassFormatter::format($class));

    }
}
