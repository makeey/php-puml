<?php

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLMethod;
use PHPUnit\Framework\TestCase;

class UMLMethodTest extends TestCase
{
    public function test__construct(): void
    {
        $methodName = "method";
        $method = new UMLMethod($methodName);
        $this->assertEquals($methodName, $method->methodName());
        $this->assertEmpty($method->params());
    }
}
