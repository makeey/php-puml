<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\ClassMethod;
use PHPUnit\Framework\TestCase;

class ClassMethodTest extends TestCase
{
    public function testCanParseClass(): void
    {
        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test()
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $classMethod = new ClassMethod($id, $tokens);
            }
        }
        $this->assertEquals("test", $classMethod->functionName());
        $this->assertEquals("public", $classMethod->accessModifier());
    }

    public function testCanParseMethodWithOptionalParams(): void
    {
        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    function test(string \$name = null)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $classMethod = new ClassMethod($id, $tokens);
            }
        }
        $this->assertEquals("test", $classMethod->functionName());
        $this->assertCount(1, $classMethod->params());
        $this->assertEquals("public", $classMethod->accessModifier());

        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test(?string \$name)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $classMethod = new ClassMethod($id, $tokens);
            }
        }
        $this->assertEquals("test", $classMethod->functionName());
        $this->assertCount(1, $classMethod->params());
        $this->assertEquals("public", $classMethod->accessModifier());
    }

}