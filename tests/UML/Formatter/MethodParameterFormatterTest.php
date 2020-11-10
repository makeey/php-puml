<?php declare(strict_types=1);

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
        $methodParameterFormatter = new MethodParameterFormatter();
        $this->assertEquals("foo: string", $methodParameterFormatter->format($param));
    }
}
