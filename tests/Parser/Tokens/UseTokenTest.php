<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\NameSpaceToken;
use PhpUML\Parser\Tokens\UseToken;
use PHPUnit\Framework\TestCase;

class UseTokenTest extends TestCase
{
    public function testCanParseNameSpace(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
namespace Foo\Bar\Baz;
use Foo\Zoo;
class Test 
{
}
EOT
        );
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_USE) {
                $namesapce = new UseToken($id, $tokens);
                $this->assertEquals("Foo\\\\Zoo", $namesapce->fullName());
                $this->assertEquals("Zoo", $namesapce->parts()->peek());
            }
        }

        $tokens = token_get_all(
            <<<EOT
<?php
namespace Foo\Bar\Baz;
use Foo\Zoo;
class Test 
{
}
EOT
        );
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_USE) {
                $namesapce = new UseToken($id, $tokens);
                $this->assertEquals("Zoo", $namesapce->parts()->peek());
                $this->assertEquals("Foo\\\\Zoo", $namesapce->fullName());
            }
        }
    }
}
