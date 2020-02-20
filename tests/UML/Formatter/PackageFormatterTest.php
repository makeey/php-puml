<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLNamespace;
use PhpUML\UML\Formatter\NamespaceFormatter;
use PHPUnit\Framework\TestCase;

class PackageFormatterTest extends TestCase
{
    public function testFormat(): void
    {
        $package = new UMLNamespace(
            "Foo",
            [
                new UMLNamespace(
                    "Bar",
                    [],
                    [
                        new UMLClass("Fee", [], [])
                    ],
                    []
                )
            ],
            [],
            []
        );

        $expecterString = <<<EOT

namespace Foo {

namespace Foo.Bar {
class Fee
{
    
    --
    
}

}



}
EOT;
        $this->assertEquals($expecterString, NamespaceFormatter::format($package));
    }

    public function testFormatNestedPackages(): void
    {
        $package = new UMLNamespace(
            "Foo",
            [
                new UMLNamespace(
                    "Bar",
                    [],
                    [
                        new UMLClass("Fee", [], [])
                    ],
                    []
                ),
                new UMLNamespace(
                    "Ret",
                    [],
                    [
                        new UMLClass("Too", [], [])
                    ],
                    []
                )
            ],
            [],
            []
        );

        $expectedString = <<<EOT

namespace Foo {

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



}
EOT;
        $this->assertEquals($expectedString, NamespaceFormatter::format($package));
    }

    public function testFormatNested3Packages(): void
    {
        $package = new UMLNamespace(
            "Foo",
            [
                new UMLNamespace(
                    "Bar",
                    [
                        new UMLNamespace(
                            "Ret",
                            [],
                            [
                                new UMLClass("Too", [], [])
                            ],
                            []
                        )
                    ],
                    [
                        new UMLClass("Fee", [], [])
                    ],
                    []
                ),

            ],
            [],
            []
        );

        $expectedString = <<<EOT

namespace Foo {

namespace Foo.Bar {

namespace Foo.Bar.Ret {
class Too
{
    
    --
    
}

}

class Fee
{
    
    --
    
}

}


}
EOT;
        $this->assertEquals($expectedString, NamespaceFormatter::format($package));
    }
}
