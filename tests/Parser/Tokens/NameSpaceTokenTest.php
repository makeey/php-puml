<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\NamespaceToken;
use PHPUnit\Framework\TestCase;

class NameSpaceTokenTest extends TestCase
{
    public function testCanParseNameSpace(): void
    {
        $tokens = token_get_all(
            <<<EOT
<?php
namespace Foo\Bar\Baz;
class Test 
{
}
EOT
        );
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_NAMESPACE) {
                $namesapce = new NamespaceToken($id, $tokens);
                $this->assertEquals("Foo\\\\Bar\\\\Baz", $namesapce->name());
            }
        }
    }
}
