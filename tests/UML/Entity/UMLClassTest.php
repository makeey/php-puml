<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLClass;
use PHPUnit\Framework\TestCase;

class UMLClassTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "className";
        $extends = "Exception";
        $namespace = "Application";
        $implements = ["IException"];
        $methods = [];
        $properties = [];
        $umlClass = new UMLClass($name, $methods, $properties, $extends, $namespace, $implements);
        $this->assertEquals($name, $umlClass->className());
        $this->assertEquals($properties, $umlClass->properties());
        $this->assertEquals($methods, $umlClass->methods());
        $this->assertEquals($implements, $umlClass->implements());
        $this->assertEquals($namespace, $umlClass->namespace());
        $this->assertEquals($extends, $umlClass->extends());
    }
}
