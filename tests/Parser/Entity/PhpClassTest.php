<?php

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpMethod;
use PHPUnit\Framework\TestCase;

class PhpClassTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "Foo";
        $methods = [];
        $properties = [];
        $class = new PhpClass($name, $properties, $methods, "");
        $this->assertEquals($name, $class->name());
        $this->assertEquals($properties, $class->properties());
        $this->assertEquals($methods, $class->methods());
    }
    public function testCanAppendMember(): void
    {
        $name = "Foo";
        $methods = [];
        $properties = [];
        $class = new PhpClass($name, $properties, $methods, "");
        $member = new PhpClassMember("bar", "public", 'string');
        $class->appendProperties($member);
        $this->assertEquals($name, $class->name());
        $this->assertEquals([$member], $class->properties());
        $this->assertEquals($methods, $class->methods());
    }
    public function testCanAppendMethod(): void
    {
        $name = "Foo";
        $methods = [];
        $properties = [];
        $class = new PhpClass($name, $properties, $methods, "");
        $method = new PhpMethod("bar", [], "public");
        $class->appendMethods($method);
        $this->assertEquals($name, $class->name());
        $this->assertEquals($properties, $class->properties());
        $this->assertEquals([$method], $class->methods());
    }
}
