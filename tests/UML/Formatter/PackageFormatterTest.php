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
package Bar
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
package Bar
{
class Fee
{
    
    --
    
}
}
package Ret
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
}
