<?php declare(strict_types=1);

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLNamespace;
use PhpUML\UML\Formatter\ClassFormatter;
use PhpUML\UML\Formatter\InterfaceFormatter;
use PhpUML\UML\Formatter\NamespaceFormatter;
use PHPUnit\Framework\TestCase;

class NamespaceFormatterTest extends TestCase
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
                        $class = new UMLClass("Fee", [], [])
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



}
EOT;

        $interfaceFormatterMock = $this->createMock(InterfaceFormatter::class);
        $classFormatterMock = $this->createMock(ClassFormatter::class);
        $classFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($class)
            ->willReturn('class Fee
{
    
    --
    
}');
        $namespaceFormatter = new NamespaceFormatter($interfaceFormatterMock, $classFormatterMock);
        $this->assertEquals($expectedString, $namespaceFormatter->format($package));
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
                        $feeClass = new UMLClass("Fee", [], [])
                    ],
                    []
                ),
                new UMLNamespace(
                    "Ret",
                    [],
                    [
                        $tooClass = new UMLClass("Too", [], [])
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

        $interfaceFormatterMock = $this->createMock(InterfaceFormatter::class);
        $classFormatterMock = $this->createMock(ClassFormatter::class);
        $classFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($feeClass)
            ->willReturn('class Fee
{
    
    --
    
}');
        $classFormatterMock->expects($this->at(1))
            ->method('format')
            ->with($tooClass)
            ->willReturn('class Too
{
    
    --
    
}');
        $namespaceFormatter = new NamespaceFormatter($interfaceFormatterMock, $classFormatterMock);
        $this->assertEquals($expectedString, $namespaceFormatter->format($package));
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
                                $tooClass = new UMLClass("Too", [], [])
                            ],
                            []
                        )
                    ],
                    [
                        $feeClass = new UMLClass("Fee", [], [])
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
        $interfaceFormatterMock = $this->createMock(InterfaceFormatter::class);
        $classFormatterMock = $this->createMock(ClassFormatter::class);
        $classFormatterMock->expects($this->at(0))
            ->method('format')
            ->with($tooClass)
            ->willReturn('class Too
{
    
    --
    
}');
        $classFormatterMock->expects($this->at(1))
            ->method('format')
            ->with($feeClass)
            ->willReturn('class Fee
{
    
    --
    
}');
        $namespaceFormatter = new NamespaceFormatter($interfaceFormatterMock, $classFormatterMock);
        $this->assertEquals($expectedString, $namespaceFormatter->format($package));
    }
}
