<?php

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLProperty;
use PHPUnit\Framework\TestCase;

class UMLPropertyTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "name";
        $type = "string";
        $accessModifier = "public";
        $property = new UMLProperty($name, $accessModifier, $type);
        $this->assertEquals($name, $property->name());
        $this->assertEquals($type, $property->type());
        $this->assertEquals($accessModifier, $property->accessModifier());
    }

    public function testCanAcceptTypeAsNull(): void
    {
        $name = "name";
        $type = null;
        $accessModifier = "public";
        $property = new UMLProperty($name, $accessModifier, $type);
        $this->assertEquals($name, $property->name());
        $this->assertEquals($type, $property->type());
        $this->assertEquals($accessModifier, $property->accessModifier());
    }
}
