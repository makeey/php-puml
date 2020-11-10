<?php declare(strict_types=1);

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpInterface;
use PHPUnit\Framework\TestCase;

class PhpFileTest extends TestCase
{
    public function test__construct(): void
    {
        $file = new PhpFile();
        $this->assertEquals(null, $file->namespace());
        $this->assertEmpty($file->classes());
    }

    public function testAppendClass(): void
    {
        $file = new PhpFile();
        $this->assertEquals(null, $file->namespace());
        $this->assertEmpty($file->classes());
        $phpClass = new PhpClass("Foo", [], [], "");
        $file->appendClass($phpClass);
        $this->assertEquals([$phpClass], $file->classes());
    }


    public function testSetNameSpace(): void
    {
        $file = new PhpFile();
        $this->assertEquals(null, $file->namespace());
        $file->setNameSpace("Foo\\\\Bar");
        $this->assertEquals("Foo\\\\Bar", $file->namespace());
    }

    public function testAppendClasses(): void
    {
        $file = new PhpFile();
        $phpClasses = [
            new PhpClass("Bar", [], [], ""),
            new PhpClass("Foo", [], [], "")
        ];
        $file->appendClasses(...$phpClasses);
        $this->assertEquals($phpClasses, $file->classes());
    }

    public function testAppendInterfaces(): void
    {
        $file = new PhpFile();
        $phpClasses = [
            new PhpInterface("Bar", [], "", ""),
            new PhpInterface("Foo", [], "", "")
        ];
        $file->appendInterfaces(...$phpClasses);
        $this->assertEquals($phpClasses, $file->interfaces());
    }

    public function testAppendUsedClasses(): void
    {
        $file = new PhpFile();
        $wrongFormat = [
            'key' => 'value'
        ];
        $this->expectExceptionObject(new \InvalidArgumentException("Wrong format for used classes. Array must contains name and fullName"));
        $file->appendUsedClass($wrongFormat);

        $useClasses = [
            [
                'name' => 'Foo',
                'fullName' => 'Bar\\\\Foo'
            ]
        ];
        $file->appendUsedClasses($useClasses);
        $this->assertEquals($useClasses, $file->usedClasses());
    }
}
