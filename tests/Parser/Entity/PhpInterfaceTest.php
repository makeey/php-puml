<?php declare(strict_types=1);

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpInterface;
use PhpUML\Parser\Entity\PhpMethod;
use PHPUnit\Framework\TestCase;

class PhpInterfaceTest extends TestCase
{
    public function test__construct(): void
    {
        $phpInterface = new PhpInterface(
            'Foo',
            [],
            'Bar',
            null
        );
        $this->assertEquals('Foo', $phpInterface->interfaceName());
        $this->assertEquals('Bar', $phpInterface->namespace());
        $this->assertEmpty($phpInterface->methods());
        $this->assertNull($phpInterface->parent());
    }

    public function testAppendMethods(): void
    {
        $phpInterface = new PhpInterface(
            'Foo',
            [],
            'Bar',
            null
        );
        $phpInterface->appendMethods($method = new PhpMethod('bar', [], 'public'));
        $this->assertEquals([$method], $phpInterface->methods());
    }
}
