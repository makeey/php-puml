<?php

namespace PhpUML\Tests\UML\Entity;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLPackage;
use PHPUnit\Framework\TestCase;

class UMLDiagramTest extends TestCase
{

    public function testCanMergeDiagramWithSimpleCase()
    {
        $umlDiagramLeft = new UMLDiagram(
            [
                new UMLPackage("Foo", [

                ], [new UMLClass("Foo", [], []),])
            ]
        );

        $umlDiagramRight = new UMLDiagram(
            [
                new UMLPackage("Baz", [

                ], [new UMLClass("Foo", [], []),])
            ]
        );

        $expectedDiagram = new UMLDiagram(
            [
                new UMLPackage("Foo", [

                ], [new UMLClass("Foo", [], []),]),
                new UMLPackage("Baz", [

                ], [new UMLClass("Foo", [], []),])
            ]
        );

        $this->assertEquals($expectedDiagram, $umlDiagramLeft->mergeDiagram($umlDiagramRight));
    }

    public function testMergeDiagram()
    {
        $umlDiagramLeft = new UMLDiagram(
            [
                new UMLPackage("Foo", [
                        new UMLPackage("Bar", [], [])]
                    , [])
            ]
        );

        $umlDiagramRight = new UMLDiagram(
            [
                new UMLPackage("Foo", [
                        new UMLPackage("Zoo", [], [])]
                    , [])
            ]
        );

        $expectedDiagram = new UMLDiagram(
            [
                new UMLPackage("Foo", [
                    new UMLPackage("Bar", [], []),
                    new UMLPackage("Zoo", [], [])
                ], [])
            ]
        );

        $this->assertEquals($expectedDiagram, $umlDiagramLeft->mergeDiagram($umlDiagramRight));
    }


    public function testMergeDiagramWithManyNestead()
    {
        $umlDiagramLeft = new UMLDiagram(
        [
            new UMLPackage("Foo",
                [
                    new UMLPackage(
                        "Bar",
                        [
                            new UMLPackage(
                                "Zar",
                                [

                                ],
                                [  new UMLClass("ZarClass", [], [])]
                            )
                        ],
                        [  new UMLClass("BarClass", [], [])]
                    )
                ]
                ,
                [
                    new UMLClass("FooClass", [], [])
                ]
            )
        ]
    );

        $umlDiagramRight =  new UMLDiagram(
            [
                new UMLPackage("Foo",
                    [
                        new UMLPackage(
                            "Bar",
                            [
                                new UMLPackage(
                                    "Zar",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZarClass2", [], [])
                                    ]
                                )
                            ],
                            [  new UMLClass("BarClass2", [], [])]
                        ),

                         new UMLPackage(
                             "Baz",
                             [
                                 new UMLPackage(
                                     "Zaw",
                                     [

                                     ],
                                     [
                                         new UMLClass("ZawClass", [], [])
                                     ]
                                 )
                             ],
                             [  new UMLClass("BazClass", [], [])]
                         )
                    ]
                    ,
                    [
                        new UMLClass("FooClass2", [], [])
                    ]
                )
            ]
        );


        $expectedDiagram = new UMLDiagram(
            [
                new UMLPackage("Foo",
                    [
                        new UMLPackage(
                            "Bar",
                            [
                                new UMLPackage(
                                    "Zar",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZarClass", [], []),
                                        new UMLClass("ZarClass2", [], [])
                                    ]
                                )
                            ],
                            [
                                new UMLClass("BarClass", [], []),
                                new UMLClass("BarClass2", [], [])
                            ]
                        ),
                        new UMLPackage(
                            "Baz",
                            [
                                new UMLPackage(
                                    "Zaw",
                                    [

                                    ],
                                    [
                                        new UMLClass("ZawClass", [], [])
                                    ]
                                )
                            ],
                            [  new UMLClass("BazClass", [], [])]
                        )
                    ]
                    ,
                    [
                        new UMLClass("FooClass", [], []),
                        new UMLClass("FooClass2", [], [])
                    ]
                )
            ]
        );


        $this->assertEquals($expectedDiagram, $umlDiagramLeft->mergeDiagram($umlDiagramRight));
    }
}
