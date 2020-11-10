<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Entity\UMLProperty;
use PHPUnit\Framework\TestCase;

class UMLMethodParameterTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "foo";
        $type = "int";
        $accessModifier = "public";
        $prop = new UMLProperty($name, $accessModifier, $type);
        $this->assertEquals($name, $prop->name());
        $this->assertEquals($accessModifier, $prop->accessModifier());
        $this->assertEquals($type, $prop->type());
    }
}
