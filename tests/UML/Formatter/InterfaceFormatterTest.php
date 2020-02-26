<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Formatter\InterfaceFormatter;
use PhpUML\UML\Formatter\MethodFormatter;
use PHPUnit\Framework\TestCase;

class InterfaceFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $method = new UMLMethod(
            'generate',
            'private',
            new UMLMethodParameter('param', 'string')
        );

        $methodFormatterMock = $this->createMock(MethodFormatter::class);
        $methodFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($method)
            ->willReturn('- generate(param: string)');
        $interfaceFormatter = new InterfaceFormatter($methodFormatterMock);
        $interface = new UMLInterface("Foo", []);
        $expectedString = "interface Foo \n{\n\t\n}\n";
        $this->assertEquals($expectedString, $interfaceFormatter->format($interface));

        $interface = new UMLInterface("Foo", [
            $method
        ]);
        $expectedString = 'interface Foo 
{
	- generate(param: string)
}
';
        $this->assertEquals($expectedString, $interfaceFormatter->format($interface));
    }
}
