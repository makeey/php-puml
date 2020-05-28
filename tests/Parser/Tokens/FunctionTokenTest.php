<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\FunctionToken;
use PHPUnit\Framework\TestCase;

class FunctionTokenTest extends TestCase
{
    public function testCanParseClass(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test()
    {
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
        }
    }

    public function testCanParseMethodWithOptionalParams(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(string \$name = null)
    {
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertCount(1, $functionToken->params());
        }
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(?string \$name)
    {
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertCount(1, $functionToken->params());
        }
    }

    public function testCanParseMethodWithParams(): void
    {
        $tokens = token_get_all(
            <<<EOT
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


        $tokens = token_get_all(
            <<<EOT
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

        $tokens = token_get_all(
            <<<EOT
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


        $tokens = token_get_all(
            <<<EOT
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

    public function testCanParseClassWithVariadic(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(Foo ...\$foes)
    {
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'Foo[]',
                    'variable' => '$foes'
                ]
            ], $functionToken->params());
        }
    }

    public function testParseFunctionWithBooleanParamsWithDefaultValueTrue(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(bool \$variable = true ) : bool
    {
        return \$variable;
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'bool',
                    'variable' => '$variable'
                ]
            ], $functionToken->params());
        }
    }

    public function testCanParseFunctionWithArrayParamsWhichEmptyByDefault(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(array \$variable = [])
    {
        return \$variable;
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'array',
                    'variable' => '$variable'
                ]
            ], $functionToken->params());
        }
    }

    public function testParseFunctionWithBooleanParamsWithDefaultValueFalse(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(bool \$variable = false) : bool
    {
        return \$variable;
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'bool',
                    'variable' => '$variable'
                ]
            ], $functionToken->params());
        }
    }

    public function testCanParseTwoParametersWithDefaultValue(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(array \$variable = null, bool \$booleanVar = true)
    {
        return \$variable;
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'array',
                    'variable' => '$variable'
                ],
                [
                    'type' => 'bool',
                    'variable' => '$booleanVar'
                ]
            ], $functionToken->params());
        }
    }


    public function testShouldParseReferenceType(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(int &\$b)
    {
        return ++\$b;
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'int',
                    'variable' => '&$b'
                ]
            ], $functionToken->params());
        }


        $tokens = token_get_all(
            <<<EOT
<?php
class Foo
{
    public function test(string \$firstParam, int &\$b, string \$thirdParam)
    {
        return ++\$b;
    }
}
EOT
        );
        $functionToken = null;
        foreach ($tokens as $id => $value) {
            if ($value[0] === T_FUNCTION) {
                $functionToken = new FunctionToken($id, $tokens);
            }
        }
        if ($functionToken !== null) {
            $this->assertEquals("test", $functionToken->functionName());
            $this->assertEquals([
                [
                    'type' => 'string',
                    'variable' => '$firstParam'
                ],
                [
                    'type' => 'int',
                    'variable' => '&$b'
                ],
                [
                    'type' => 'string',
                    'variable' => '$thirdParam'
                ],
            ], $functionToken->params());
        }
    }
}
