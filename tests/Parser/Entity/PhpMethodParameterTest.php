<?php

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpMethodParameter;
use PHPUnit\Framework\TestCase;

class PhpMethodParameterTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "name";
        $type = "string";
        $methodParams = new PhpMethodParameter($name,$type);
        $this->assertEquals($name, $methodParams->name());
        $this->assertEquals($type, $methodParams->type());
    }

    public function testCanSetMixedByDefault(): void
    {
        $name = "name";
        $type = null;
        $methodParams = new PhpMethodParameter($name,$type);
        $this->assertEquals($name, $methodParams->name());
        $this->assertEquals("mixed", $methodParams->type());
    }
}
