<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLPackage;
use PhpUML\UML\Formatter\PackageFormatter;
use PHPUnit\Framework\TestCase;

class PackageFormatterTest extends TestCase
{

    public function testFormat(): void
    {
        $package = new UMLPackage(
            "Foo",
            [
                new UMLPackage(
                    "Bar",
                    [],
                    [
                        new UMLClass("Fee", [], [])
                    ]
                )
            ],
            []
        );

        $expecterString = <<<EOT
package Foo
{
package Foo.Bar
{
class Fee
{
    
    --
    
}
}


}
EOT;
        $this->assertEquals($expecterString, PackageFormatter::format($package));

    }

    public function testFormatNestedPackages(): void
    {
        $package = new UMLPackage(
            "Foo",
            [
                new UMLPackage(
                    "Bar",
                    [],
                    [
                        new UMLClass("Fee", [], [])
                    ]
                ),
                new UMLPackage(
                    "Ret",
                    [],
                    [
                        new UMLClass("Too", [], [])
                    ]
                )
            ],
            []
        );

        $expectedString = <<<EOT
package Foo
{
package Foo.Bar
{
class Fee
{
    
    --
    
}
}
package Foo.Ret
{
class Too
{
    
    --
    
}
}


}
EOT;
        $this->assertEquals($expectedString, PackageFormatter::format($package));

    }

    public function testFormatNested3Packages(): void
    {
        $package = new UMLPackage(
            "Foo",
            [
                new UMLPackage(
                    "Bar",
                    [
                        new UMLPackage(
                            "Ret",
                            [],
                            [
                                new UMLClass("Too", [], [])
                            ]
                        )
                    ],
                    [
                        new UMLClass("Fee", [], [])
                    ]
                ),

            ],
            []
        );

        $expectedString = <<<EOT
package Foo
{
package Foo.Bar
{
package Foo.Bar.Ret
{
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
        $this->assertEquals($expectedString, PackageFormatter::format($package));

    }
}
