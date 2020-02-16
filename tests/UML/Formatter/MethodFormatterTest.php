<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Formatter\MethodFormatter;
use PHPUnit\Framework\TestCase;

class MethodFormatterTest extends TestCase
{

    public function testFormat(): void
    {
        $method = new UMLMethod(
            "foo",
            new UMLMethodParameter(
                "bar",
                "string"
            )
        );
        $this->assertEquals("foo(bar: string)\n", MethodFormatter::format($method));

        $method = new UMLMethod(
            "foo",
            new UMLMethodParameter(
                "bar",
                "string"
            ),
            new UMLMethodParameter(
                "baz",
                "int"
            )
        );
        $this->assertEquals("foo(bar: string, baz: int)\n", MethodFormatter::format($method));
    }
}
