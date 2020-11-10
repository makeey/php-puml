<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLProperty;
use PhpUML\UML\Formatter\AccessModifierFormatter;
use PhpUML\UML\Formatter\PropertyFormatter;
use PHPUnit\Framework\TestCase;

class PropertyFormatterTest extends TestCase
{
    public function testCanPublic(): void
    {
        $accessModifierFormatterMock = $this->createMock(AccessModifierFormatter::class);
        $accessModifierFormatterMock->method('resolveAccessModifier')->with('public')->willReturn("+");
        $propertyFormatter = new PropertyFormatter($accessModifierFormatterMock);
        $property = new UMLProperty("foo", 'public', "string");
        $formatterString = $propertyFormatter->format($property);
        $expectedString = "+ foo: string";
        $this->assertEquals($formatterString, $expectedString);
    }
    public function testCanPrivate(): void
    {
        $accessModifierFormatterMock = $this->createMock(AccessModifierFormatter::class);
        $accessModifierFormatterMock->method('resolveAccessModifier')->with('private')->willReturn("-");
        $propertyFormatter = new PropertyFormatter($accessModifierFormatterMock);
        $property = new UMLProperty("foo", 'private', "string");
        $formatterString = $propertyFormatter->format($property);
        $expectedString = "- foo: string";
        $this->assertEquals($formatterString, $expectedString);
    }
    public function testCanProtected(): void
    {
        $accessModifierFormatterMock = $this->createMock(AccessModifierFormatter::class);
        $accessModifierFormatterMock->method('resolveAccessModifier')->with('protected')->willReturn("#");
        $propertyFormatter = new PropertyFormatter($accessModifierFormatterMock);
        $property = new UMLProperty("foo", 'protected', "string");
        $formatterString = $propertyFormatter->format($property);
        $expectedString = "# foo: string";
        $this->assertEquals($formatterString, $expectedString);
    }
}
