<?php

namespace PhpUML\Tests\Parser;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpInterface;
use PhpUML\Parser\Entity\PhpMethod;
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
        ], [], "");
        $this->assertEquals($expectedClass, $class);
    }

    public function testCanParseClassWithPropertiesWithMethod(): void
    {
        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
    private \$test;
    /** @var string */
    public \$baz;
    public function test()
    {
             
        if(\$true) {
       }
    }
    
    public function test2()
    {
       if(\$true) {
       }
    }
}
EOT
        );
        $this->assertCount(1, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $expectedClass = new PhpClass("Foo", [
            new PhpClassMember("\$test", "private", null),
            new PhpClassMember("\$baz", "public", "string"),
        ], [
            new PhpMethod("test", [], "public"),
            new PhpMethod("test2", [], "public")
        ], "");
        $this->assertEquals($expectedClass, $class);

    }

    public function testCanParseClassWithLoops(): void
    {


        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
    private \$test;
    /** @var string */
    public \$baz;
    public function test()
    {
        if(1) {
        \$zoo = [1,2,3];
            foreach(\$zoo as \$t){
            }
        }
    }
    
    public function test2()
    {
        if(1) {
            do
            {
            }while(true);
        }
    }
}
EOT
        );
        $this->assertCount(1, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $expectedClass = new PhpClass("Foo", [
            new PhpClassMember("\$test", "private", null),
            new PhpClassMember("\$baz", "public", "string"),
        ], [
            new PhpMethod("test", [], "public"),
            new PhpMethod("test2", [], "public"),
        ], "");
        $this->assertEquals($expectedClass, $class);
    }

    public function testCanParseClassWithSelfClass(): void
    {


        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
    private \$test;
    /** @var string */
    public \$baz;
    public function test()
    {
       return self::class;
    }
    
    public function test2()
    {
        
    }
}
EOT
        );
        $this->assertCount(1, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $expectedClass = new PhpClass("Foo", [
            new PhpClassMember("\$test", "private", null),
            new PhpClassMember("\$baz", "public", "string"),
        ], [
            new PhpMethod("test", [], "public"),
            new PhpMethod("test2", [], "public"),
        ], "");
        $this->assertEquals($expectedClass, $class);
    }

    public function testCanParseClassWithAnonFunction(): void
    {


        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
class Foo 
{
    private \$test;
    /** @var string */
    public \$baz;
    public function test()
    {
       return function(){
            echo "Anon function";
       }
    }
    
    public function test2()
    {
        
    }
}
EOT
        );
        $this->assertCount(1, $file->classes());
        /** @var PhpClass $class */
        $class = $file->classes()[0];
        $expectedClass = new PhpClass("Foo", [
            new PhpClassMember("\$test", "private", null),
            new PhpClassMember("\$baz", "public", "string"),
        ], [
            new PhpMethod("test", [], "public"),
            new PhpMethod("test2", [], "public"),
        ], "");
        $this->assertEquals($expectedClass, $class);
    }



    public function testCanParseInterface(): void
    {
        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
interface Foo 
{
}
EOT
        );
        $this->assertCount(1, $file->interfaces());
        /** @var PhpClass $class */
        $class = $file->interfaces()[0];
        $expectedInterface = new PhpInterface("Foo", [], "", null);
        $this->assertEquals($expectedInterface, $class);
    }


    public function testCanParseInterfaceWithMethod(): void
    {
        $parser = new SourceParser();
        $file = $parser(<<<EOT
<?php
interface Foo 
{
    public function bar();
}
EOT
        );
        $this->assertCount(1, $file->interfaces());
        /** @var PhpClass $class */
        $class = $file->interfaces()[0];
        $expectedInterface = new PhpInterface("Foo", [
            new PhpMethod("bar", [],'public')
        ], "", null);
        $this->assertEquals($expectedInterface, $class);
    }
}
