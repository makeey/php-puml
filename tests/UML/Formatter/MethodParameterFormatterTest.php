<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Formatter\MethodParameterFormatter;
use PHPUnit\Framework\TestCase;

class MethodParameterFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $name = "foo";
        $type = "string";
        $param = new UMLMethodParameter($name, $type);
        $this->assertEquals("foo: string", MethodParameterFormatter::format($param));
    }
}
