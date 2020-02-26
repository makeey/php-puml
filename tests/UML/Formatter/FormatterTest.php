<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLNamespace;
use PhpUML\UML\Formatter\Formatter;
use PhpUML\UML\Formatter\NamespaceFormatter;
use PhpUML\UML\Formatter\RelationFormatter;
use PHPUnit\Framework\TestCase;

class FormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $formattedNamespace = "namespace Foo {

namespace Foo.Bar {
class Fee
{
    
    --
    
}

}

namespace Foo.Ret {
class Too
{
    
    --
    
}

}



}";
        $diagram = new UMLDiagram(
            [
                $root = new UMLNamespace(
                    "Foo",
                    [
                        new UMLNamespace(
                            "Bar",
                            [],
                            [new UMLClass("Fee", [], [])],
                            []
                        ),
                        new UMLNamespace(
                            "Too",
                            [],
                            [new UMLClass("Too", [], [])],
                            []
                        )
                    ],
                    [],
                    []
                )
            ]
        );
        $namespaceFormatterMock = $this->createMock(NamespaceFormatter::class);
        $namespaceFormatterMock->expects($this->once())
            ->method('format')
            ->with($root)
            ->willReturn($formattedNamespace);

        $relationFormatterMock = $this->createMock(RelationFormatter::class);
        $relationFormatterMock->expects($this->once())
            ->method('buildRelations')
            ->with($diagram)
            ->willReturn("\n");

        $formatter = new Formatter($namespaceFormatterMock, $relationFormatterMock);

        $expectedFormatterString = "@startuml " . PHP_EOL . $formattedNamespace . "\n" . PHP_EOL . "@enduml";
        $this->assertEquals($expectedFormatterString, $formatter->format($diagram));
    }
}
