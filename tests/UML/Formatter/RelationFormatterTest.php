<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLNamespace;
use PhpUML\UML\Formatter\RelationFormatter;
use PHPUnit\Framework\TestCase;

class RelationFormatterTest extends TestCase
{
    public function testBuildEmptyRelations(): void
    {
        $expectedString = "\n";

        $diagram = new UMLDiagram([
            new UMLNamespace("", [], [], [])
        ]);

        $relationFormatter = new RelationFormatter();

        $this->assertEquals($expectedString, $relationFormatter->format($diagram));
    }

    public function testBuildRelations(): void
    {
        $expectedString = "\nApplication.Zoo --> Foo\nFoo --> IFoo\nBar --> Foo\n";

        $diagram = new UMLDiagram([
            new UMLNamespace(
                "",
                [
                    new UMLNamespace("Application", [], [
                        new UMLClass("Zoo", [], [], "Foo", "Application", [])
                    ], [])
                ],
                [
                    new UMLClass("Foo", [], [], null, null, ["IFoo"]),
                    new UMLClass("Bar", [], [], "Foo", null, [])
                ],
                [
                    new UMLInterface("IFoo", [])
                ]
            )
        ]);

        $relationFormatter = new RelationFormatter();

        $this->assertEquals($expectedString, $relationFormatter->format($diagram));
    }
}
