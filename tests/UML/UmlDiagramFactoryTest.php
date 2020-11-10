<?php declare(strict_types=1);

namespace PhpUML\Tests\UML;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpInterface;
use PhpUML\Parser\Entity\PhpMethod;
use PhpUML\Parser\Entity\PhpMethodParameter;
use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Entity\UMLNamespace;
use PhpUML\UML\Entity\UMLProperty;
use PhpUML\UML\UmlDiagramFactory;
use PHPUnit\Framework\TestCase;

class UmlDiagramFactoryTest extends TestCase
{
    public function testBuildDiagram(): void
    {
        $phpFile = new PhpFile();
        $phpFile->setNameSpace("Foo\\\\Bar\\\\Baz");
        $class = new PhpClass("Foo", [], [], $phpFile->namespace() ?? '');
        $phpFile->appendClass($class);

        $expectedUmlDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                    new UMLNamespace("Bar", [
                        new UMLNamespace(
                            "Baz",
                            [],
                            [
                                new UMLClass("Foo", [], [], null, "Foo\\\\Bar\\\\Baz")
                            ],
                            []
                        )
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
        $interface = new PhpInterface("Foo", [], $phpFile->namespace() ?? '', null);
        $phpFile->appendInterface($interface);
        $expectedUmlDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                    new UMLNamespace("Bar", [
                        new UMLNamespace(
                            "Baz",
                            [],
                            [],
                            [new UMLInterface("Foo", [])]
                        )
                    ], [], [])
                ], [], [])
            ]
        );

        $factory = new UmlDiagramFactory();
        $this->assertEquals($expectedUmlDiagram, $factory->buildDiagram($phpFile));
    }


    public function testCanBuildDiagramWithInterfacesAndClasses(): void
    {
        $phpFile = new PhpFile();
        $phpFile->setNameSpace("Foo\\\\Bar\\\\Baz");
        $interface = new PhpInterface("Foo", [
            new PhpMethod("bar", [new PhpMethodParameter('bar', 'string')], 'public')
        ], $phpFile->namespace() ?? '', null);

        $class = new PhpClass(
            "Bar",
            [
                new PhpClassMember("bar", 'public', 'string')
            ],
            [
                new PhpMethod("baz", [new PhpMethodParameter('baz', 'string')], 'public')
            ],
            $phpFile->namespace() ?? ''
        );
        $phpFile->appendInterface($interface);
        $phpFile->appendClass($class);
        $expectedUmlDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                    new UMLNamespace("Bar", [
                        new UMLNamespace(
                            "Baz",
                            [],
                            [
                                new UMLClass(
                                    "Bar",
                                    [
                                        new UMLMethod(
                                            'baz',
                                            'public',
                                            new UMLMethodParameter('baz', 'string')
                                        )
                                    ],
                                    [
                                        new UMLProperty('bar', 'public', 'string')
                                    ],
                                    null,
                                    $phpFile->namespace()
                                )
                            ],
                            [new UMLInterface("Foo", [
                                new UMLMethod(
                                    'bar',
                                    'public',
                                    new UMLMethodParameter('bar', 'string')
                                )
                            ])]
                        )
                    ], [], [])
                ], [], [])
            ]
        );

        $factory = new UmlDiagramFactory();
        $this->assertEquals($expectedUmlDiagram, $factory->buildDiagram($phpFile));
    }
}
