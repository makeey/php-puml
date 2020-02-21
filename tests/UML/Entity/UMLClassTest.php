<?php

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLClass;
use PHPUnit\Framework\TestCase;

class UMLClassTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "className";
        $methods = [];
        $properties = [];
        $umlClass = new UMLClass($name, $methods, $properties);
        $this->assertEquals($name, $umlClass->className());
        $this->assertEquals($properties, $umlClass->properties());
        $this->assertEquals($methods, $umlClass->methods());
    }
}
