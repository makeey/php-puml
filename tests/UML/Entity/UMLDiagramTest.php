<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLNamespace;
use PHPUnit\Framework\TestCase;

class UMLDiagramTest extends TestCase
{
    public function testCanMergeDiagramWithSimpleCase(): void
    {
        $umlDiagramLeft = new UMLDiagram(
            [
                new UMLNamespace("Foo", [

                ], [new UMLClass("Foo", [], []),], [])
            ]
        );

        $umlDiagramRight = new UMLDiagram(
            [
                new UMLNamespace("Baz", [

                ], [new UMLClass("Foo", [], []),], [])
            ]
        );

        $expectedDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [

                ], [new UMLClass("Foo", [], []),], []),
                new UMLNamespace("Baz", [

                ], [new UMLClass("Foo", [], []),], [])
            ]
        );

        $this->assertEquals($expectedDiagram, $umlDiagramLeft->mergeDiagram($umlDiagramRight));
    }

    public function testMergeDiagram(): void
    {
        $umlDiagramLeft = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                        new UMLNamespace("Bar", [], [], [])], [], [])
            ]
        );

        $umlDiagramRight = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                        new UMLNamespace("Zoo", [], [], [])], [], [])
            ]
        );

        $expectedDiagram = new UMLDiagram(
            [
                new UMLNamespace("Foo", [
                    new UMLNamespace("Bar", [], [], []),
                    new UMLNamespace("Zoo", [], [], [])
                ], [], [])
            ]
        );

        $this->assertEquals($expectedDiagram, $umlDiagramLeft->mergeDiagram($umlDiagramRight));
    }


    public function testMergeDiagramWithManyNested(): void
    {
        $umlDiagramLeft = new UMLDiagram(
            [
                new UMLNamespace(
                    "Foo",
                    [
                        new UMLNamespace(
                            "Bar",
                            [
                                new UMLNamespace(
                                    "Zar",
                                    [

                                    ],
                                    [new UMLClass("ZarClass", [], [])],
                                    []
                                )
                            ],
                            [new UMLClass("BarClass", [], [])],
                            []
                        )
                    ],
                    [
                        new UMLClass("FooClass", [], [])
                    ],
                    []
                )
            ]
        );

        $umlDiagramRight = new UMLDiagram(
            [
                new UMLNamespace(
                    "Foo",
                    [
                        new UMLNamespace(
                            "Bar",
                            [
                                new UMLNamespace(
                                    "Zar",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZarClass2", [], [])
                                    ],
                                    []
                                )
                            ],
                            [new UMLClass("BarClass2", [], [])],
                            []
                        ),

                        new UMLNamespace(
                            "Baz",
                            [
                                new UMLNamespace(
                                    "Zaw",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZawClass", [], [])
                                    ],
                                    []
                                )
                            ],
                            [new UMLClass("BazClass", [], [])],
                            []
                        )
                    ],
                    [
                        new UMLClass("FooClass2", [], [])
                    ],
                    []
                )
            ]
        );


        $expectedDiagram = new UMLDiagram(
            [
                new UMLNamespace(
                    "Foo",
                    [
                        new UMLNamespace(
                            "Bar",
                            [
                                new UMLNamespace(
                                    "Zar",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZarClass", [], []),
                                        new UMLClass("ZarClass2", [], [])
                                    ],
                                    []
                                )
                            ],
                            [
                                new UMLClass("BarClass", [], []),
                                new UMLClass("BarClass2", [], [])
                            ],
                            []
                        ),
                        new UMLNamespace(
                            "Baz",
                            [
                                new UMLNamespace(
                                    "Zaw",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZawClass", [], [])
                                    ],
                                    []
                                )
                            ],
                            [new UMLClass("BazClass", [], [])],
                            []
                        )
                    ],
                    [
                        new UMLClass("FooClass", [], []),
                        new UMLClass("FooClass2", [], [])
                    ],
                    []
                )
            ]
        );


        $this->assertEquals($expectedDiagram, $umlDiagramLeft->mergeDiagram($umlDiagramRight));
    }
}
