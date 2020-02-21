<?php

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpFile;
use PHPUnit\Framework\TestCase;

class PhpFileTest extends TestCase
{
    public function testAppendClass(): void
    {
        $file = new PhpFile();
        $this->assertEquals(null, $file->namespace());
        $this->assertEmpty($file->classes());
        $phpClass = new PhpClass("Foo", [], [], "");
        $file->appendClass($phpClass);
        $this->assertEquals([$phpClass], $file->classes());
    }

    public function test__construct(): void
    {
        $file = new PhpFile();
        $this->assertEquals(null, $file->namespace());
        $this->assertEmpty($file->classes());
    }

    public function testSetNameSpace(): void
    {
        $file = new PhpFile();
        $this->assertEquals(null, $file->namespace());
        $this->assertEmpty($file->classes());
        $file->setNameSpace("Foo\\\\Bar");
        $this->assertEquals("Foo\\\\Bar", $file->namespace());
    }
}
