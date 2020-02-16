<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\VariableToken;
use PHPUnit\Framework\TestCase;

class VariableTokenTest extends TestCase
{

    public function testCanPaseOneVariable()
    {
        $tokens = token_get_all(<<<EOT
<?php 
class Tes{
{
    private \$test;
}
EOT
        );
        $variables = [];
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_VARIABLE) {
                $variables[] = new VariableToken($id, $tokens);
            }
        }
        $this->assertCount(1, $variables);
        $this->assertEquals("\$test", $variables[0]->name());
    }
}