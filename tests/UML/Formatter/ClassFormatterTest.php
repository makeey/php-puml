<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLProperty;
use PhpUML\UML\Formatter\ClassFormatter;
use PhpUML\UML\Formatter\MethodFormatter;
use PhpUML\UML\Formatter\PropertyFormatter;
use PHPUnit\Framework\TestCase;

class ClassFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $properties  = [
            new UMLProperty("bar", "private", "float")
        ];
        $methods = [
            new UMLMethod("baz", "public")
        ];

        $class = new UMLClass("Foo", $methods, $properties);

        $methodFormatterMock = $this->createMock(MethodFormatter::class);
        $methodFormatterMock->method('format')->with($methods[0])->willReturn('+ baz()');
        $propertyFormatterMock = $this->createMock(PropertyFormatter::class);
        $propertyFormatterMock->method('format')->with($properties[0])->willReturn('- bar: float');
        $classFormatter = new ClassFormatter($methodFormatterMock, $propertyFormatterMock);
        $expectedString = <<<EOT
class {$class->className()}
{
    - bar: float
    --
    + baz()
}
EOT;
        $this->assertEquals($expectedString, $classFormatter->format($class));

        $properties  = [
            new UMLProperty("bar", "private", "float"),
              new UMLProperty("baq", "public", "float")
        ];
        $methods = [
            new UMLMethod("baz", "public"),
            new UMLMethod("oof", "public")
        ];

        $class = new UMLClass("Foo", $methods, $properties);

        $methodFormatterMock = $this->createMock(MethodFormatter::class);
        $methodFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($methods[0])
            ->willReturn('+ baz()');
        $methodFormatterMock->expects($this->at(1))
            ->method('format')
            ->with($methods[1])
            ->willReturn('+ oof()');
        $propertyFormatterMock = $this->createMock(PropertyFormatter::class);
        $propertyFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($properties[0])
            ->willReturn('- bar: float');
        $propertyFormatterMock->expects($this->at(1))
            ->method('format')
            ->with($properties[1])
            ->willReturn('+ baq: float');
        $classFormatter = new ClassFormatter($methodFormatterMock, $propertyFormatterMock);

        $expectedString = <<<EOT
class {$class->className()}
{
    - bar: float
    + baq: float
    --
    + baz()
    + oof()
}
EOT;
        $this->assertEquals($expectedString, $classFormatter->format($class));
    }
}
