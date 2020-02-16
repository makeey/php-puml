<?php

namespace PhpUML\Tests\Parser;

use function DI\string;
use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\SourceParser;
use PHPUnit\Framework\TestCase;

class SourceParserTest extends TestCase
{
    public function testParseSimpleClassWithoutMethod(): void
    {
        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
}
EOT
);
        $this->assertCount(1, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $this->assertEquals("Foo", $class->name());
        $this->assertEmpty($class->methods());
        $this->assertEmpty($class->properties());
    }

    public function testParseTwoClassInOneFile(): void
    {
        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
}
class Baz
{
}
EOT
        );
        $this->assertCount(2, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $this->assertEquals("Foo", $class->name());
        $this->assertEmpty($class->methods());
        $this->assertEmpty($class->properties());
        $class = $file->classes()[1];
        $this->assertEquals("Baz", $class->name());
        $this->assertEmpty($class->methods());
        $this->assertEmpty($class->properties());
    }

    public function testCanParseClassWithPropertiesWithoutMethod(): void
    {
        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
    private \$test;
    /** @var string */
    public \$baz;
}
EOT
        );
        $this->assertCount(1, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $expectedClass = new PhpClass("Foo", [
            new PhpClassMember("\$test", "private", null),
            new PhpClassMember("\$baz", "public", "string"),
        ], []);
        $this->assertEquals($expectedClass, $class);
    }
}
