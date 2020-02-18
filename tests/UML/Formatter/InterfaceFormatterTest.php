<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Formatter\InterfaceFormatter;
use PHPUnit\Framework\TestCase;

class InterfaceFormatterTest extends TestCase
{

    public function testFormat()
    {
        $interface = new UMLInterface("Foo", []);
        $expectedString = "interface Foo \n{\n\t\n}\n";
        $this->assertEquals($expectedString, InterfaceFormatter::format($interface));
    }
}
