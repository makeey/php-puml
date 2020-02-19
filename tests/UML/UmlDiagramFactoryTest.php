<?php

namespace PhpUML\UML\Tests;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpInterface;
use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLNamespace;
use PhpUML\UML\UmlDiagramFactory;
use PHPUnit\Framework\TestCase;

class UmlDiagramFactoryTest extends TestCase
{
    public function testBuildDiagram(): void
    {
        $phpFile = new PhpFile();
        $phpFile->setNameSpace("Foo\\\\Bar\\\\Baz");
        $class = new PhpClass("Foo", [], [], $phpFile->namespace());
        $phpFile->appendClass($class);

        $expectedUmlDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                    new UMLNamespace("Bar", [
                        new UMLNamespace("Baz", [],
                            [
                                new UMLClass("Foo", [], [],null, "Foo\\\\Bar\\\\Baz")
                            ], [])
                    ], [], [])
                ], [], [])
            ]
        );

        $factory = new UmlDiagramFactory();
        $this->assertEquals($expectedUmlDiagram, $factory->buildDiagram($phpFile));
    }


    public function testCanBuildDiagramWithInterfaces(): void
    {
        $phpFile = new PhpFile();
        $phpFile->setNameSpace("Foo\\\\Bar\\\\Baz");
        $interface = new PhpInterface("Foo", [], $phpFile->namespace(), null);
        $phpFile->appendInterface($interface);
        $expectedUmlDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                    new UMLNamespace("Bar", [
                        new UMLNamespace("Baz", [],
                            [], [new UMLInterface("Foo", [])])
                    ], [], [])
                ], [], [])
            ]
        );

        $factory = new UmlDiagramFactory();
        $this->assertEquals($expectedUmlDiagram, $factory->buildDiagram($phpFile));
    }
}
