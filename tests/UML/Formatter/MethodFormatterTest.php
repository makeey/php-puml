<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Formatter\AccessModifierFormatter;
use PhpUML\UML\Formatter\MethodFormatter;
use PhpUML\UML\Formatter\MethodParameterFormatter;
use PHPUnit\Framework\TestCase;

class MethodFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $method = new UMLMethod(
            "foo",
            "public",
            new UMLMethodParameter(
                "bar",
                "string"
            )
        );

        $parameterFormatterMock = $this->createMock(MethodParameterFormatter::class);
        $parameterFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($method->params()[0])
            ->willReturn('bar: string');

        $accessModifierFormatterMock = $this->createMock(AccessModifierFormatter::class);
        $accessModifierFormatterMock->expects($this->at(0))
            ->method('resolveAccessModifier')
            ->with('public')
            ->willReturn('+');


        $methodFormatter = new MethodFormatter($accessModifierFormatterMock, $parameterFormatterMock);

        $this->assertEquals("+ foo(bar: string)", $methodFormatter->format($method));
    }

    public function testFormatWithMultiplePrameters(): void
    {
        $method = new UMLMethod(
            "foo",
            "public",
            new UMLMethodParameter(
                "bar",
                "string"
            ),
            new UMLMethodParameter(
                "baz",
                "int"
            )
        );

        $parameterFormatterMock = $this->createMock(MethodParameterFormatter::class);
        $parameterFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($method->params()[0])
            ->willReturn('bar: string');
        $parameterFormatterMock->expects($this->at(1))
            ->method('format')
            ->with($method->params()[1])
            ->willReturn('baz: int');

        $accessModifierFormatterMock = $this->createMock(AccessModifierFormatter::class);
        $accessModifierFormatterMock->expects($this->at(0))
            ->method('resolveAccessModifier')
            ->with('public')
            ->willReturn('+');


        $methodFormatter = new MethodFormatter($accessModifierFormatterMock, $parameterFormatterMock);

        $this->assertEquals("+ foo(bar: string, baz: int)", $methodFormatter->format($method));
    }
}
