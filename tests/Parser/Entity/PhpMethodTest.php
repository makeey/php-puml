<?php

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpMethod;
use PHPUnit\Framework\TestCase;

class PhpMethodTest extends TestCase
{
    public function test__construct()
    {
        $methodName = 'methodName';
        $params = [];
        $method = new PhpMethod($methodName, $params, "public");
        $this->assertEquals($methodName, $method->name());
        $this->assertEmpty($method->parameters());
        $this->assertEquals("public", $method->accessModifier());
    }
}
