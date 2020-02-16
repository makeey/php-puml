<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\FunctionToken;
use PHPUnit\Framework\TestCase;

class FunctionTokenTest extends TestCase
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
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        $this->assertEquals("test", $functionToken->functionName());
    }

    public function testCanParseMethodWithOptionalParams(): void
    {
        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test(string \$name = null)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        $this->assertEquals("test", $functionToken->functionName());
        $this->assertCount(1, $functionToken->params());

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
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        $this->assertEquals("test", $functionToken->functionName());
        $this->assertCount(1, $functionToken->params());
    }

    public function testCanParseMethodWithParams(): void
    {
        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test(int \$foo)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
                $this->assertCount(1, $params = $functionToken->params());
                $this->assertEquals("int", $params[0]['type']);
                $this->assertEquals("\$foo", $params[0]['variable']);
            }
        }


        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test(int \$foo, string \$baz, Name \$class)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
                $this->assertCount(3, $params = $functionToken->params());
                $this->assertEquals("int", $params[0]['type']);
                $this->assertEquals("\$foo", $params[0]['variable']);
                $this->assertEquals("string", $params[1]['type']);
                $this->assertEquals("\$baz", $params[1]['variable']);
                $this->assertEquals("Name", $params[2]['type']);
                $this->assertEquals("\$class", $params[2]['variable']);
            }
        }

        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test(\$foo)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
                $this->assertCount(1, $params = $functionToken->params());
                $this->assertEquals("mixed", $params[0]['type']);
                $this->assertEquals("\$foo", $params[0]['variable']);
            }
        }


        $tokens = token_get_all(<<<EOT
<?php
class Foo
{
    public function test(\$foo, int \$baz)
    {
    }
}
EOT
        );
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
                $this->assertCount(2, $params = $functionToken->params());
                $this->assertEquals("mixed", $params[0]['type']);
                $this->assertEquals("\$foo", $params[0]['variable']);
                $this->assertEquals("int", $params[1]['type']);
                $this->assertEquals("\$baz", $params[1]['variable']);
            }
        }

    }
}