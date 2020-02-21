<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\ClassToken;
use PHPUnit\Framework\TestCase;

class ClassTokenTest extends TestCase
{
    public function testCanParseClass(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php

class OneClass
{
}
EOT
        );
        $class = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_CLASS) {
                $class = new ClassToken($id, $tokens);
            }
        }
        if ($class !== null) {
            $this->assertEquals("OneClass", $class->className());
            $this->assertEquals(null, $class->parent());
        }
    }

    public function testCanParseClassWithParentClass(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo extends Bar
{

}
EOT
        );
        $class = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_CLASS) {
                $class = new ClassToken($id, $tokens);
            }
        }
        if ($class !== null) {
            $this->assertEquals("Foo", $class->className());
            $this->assertEquals("Bar", $class->parent());
        }
    }

    public function testCanParseClassWithParentClassWithNameSpace(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo extends Bar\Baz
{

}
EOT
        );
        $class = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_CLASS) {
                $class = new ClassToken($id, $tokens);
            }
        }
        if ($class !== null) {
            $this->assertEquals("Foo", $class->className());
            $this->assertEquals("Bar\\\\Baz", $class->parent());
        }
    }

    public function testCanParseClassWithParentClassAndOneInterface(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo extends Bar implements Baz
{

}
EOT
        );
        $class = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_CLASS) {
                $class = new ClassToken($id, $tokens);
            }
        }
        if ($class !== null) {
            $this->assertEquals("Foo", $class->className());
            $this->assertEquals("Bar", $class->parent());
            $this->assertCount(1, $class->interfaces());
            $this->assertEquals("Baz", $class->interfaces()[0]);
        }
    }

    public function testCanParseClassWithParentClassAndTwoInterface(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo extends Bar implements Baz, Zoo
{

}
EOT
        );
        $class = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_CLASS) {
                $class = new ClassToken($id, $tokens);
            }
        }
        if ($class !== null) {
            $this->assertEquals("Foo", $class->className());
            $this->assertEquals("Bar", $class->parent());
            $this->assertCount(2, $class->interfaces());
            $this->assertEquals("Baz", $class->interfaces()[0]);
            $this->assertEquals("Zoo", $class->interfaces()[1]);
        }
    }
}
