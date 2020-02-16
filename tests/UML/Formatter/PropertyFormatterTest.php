<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLProperty;
use PhpUML\UML\Formatter\PropertyFormatter;
use PHPUnit\Framework\TestCase;

class PropertyFormatterTest extends TestCase
{
    public function testCanPublic(): void
    {
        $property = new UMLProperty("foo", 'public', "string");
        $formatterString = PropertyFormatter::format($property);
        $expectedString = "+ foo: string";
        $this->assertEquals($formatterString, $expectedString);
    }
    public function testCanPrivate(): void
    {
        $property = new UMLProperty("foo", 'private', "string");
        $formatterString = PropertyFormatter::format($property);
        $expectedString = "- foo: string";
        $this->assertEquals($formatterString, $expectedString);
    }
    public function testCanProtected(): void
    {
        $property = new UMLProperty("foo", 'protected', "string");
        $formatterString = PropertyFormatter::format($property);
        $expectedString = "# foo: string";
        $this->assertEquals($formatterString, $expectedString);
    }
}
