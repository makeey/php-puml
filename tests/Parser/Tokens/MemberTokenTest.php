<?php

namespace PhpUML\Tests\Parser\Tokens;

use PhpUML\Parser\Tokens\MemberToken;
use PHPUnit\Framework\TestCase;

class MemberTokenTest extends TestCase
{

    public function testCanParseMember(): void
    {
        $tokens = token_get_all(<<<EOT
<?php
class Foo 
{
    private \$privateMember;
    protected \$protectedMember;
    public \$publicMember;
}
EOT
        );

        $members = [];
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_VARIABLE) {
                $members[] = new MemberToken($id, $tokens);
            }
        }


        $this->assertCount(3, $members);
        $expectedData =
            [
                [
                    'accessModifier' => 'private',
                    'name' => '$privateMember',
                ],
                [
                    'accessModifier' => 'protected',
                    'name' => '$protectedMember',
                ],
                [
                    'accessModifier' => 'public',
                    'name' => '$publicMember',
                ],
            ];

        $this->assertEquals($expectedData,
            array_map(static function (MemberToken $memberToken): array {
                return [
                    'accessModifier' => $memberToken->accessModifier(),
                    'name' => $memberToken->name()
                ];
            }, $members));

    }


    public function testCanParseMemberWithType(): void
    {
        $tokens = token_get_all(<<<EOT
<?php
class Foo 
{
    /** @var string */
    private \$privateMember;
     /** @var array */
    protected \$protectedMember;
     /** @var Foo */
    public \$publicMember;
    public \$nullType;
}
EOT
        );

        $members = [];
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_VARIABLE) {
                $members[] = new MemberToken($id, $tokens);
            }
        }

        $this->assertCount(4, $members);
        $expectedData =
            [
                [
                    'accessModifier' => 'private',
                    'name' => '$privateMember',
                    'type' => 'string'
                ],
                [
                    'accessModifier' => 'protected',
                    'name' => '$protectedMember',
                    'type' => 'array'
                ],
                [
                    'accessModifier' => 'public',
                    'name' => '$publicMember',
                    'type' => 'Foo'
                ],
                [
                    'accessModifier' => 'public',
                    'name' => '$nullType',
                    'type' => null
                ],
            ];

        $this->assertEquals($expectedData,
            array_map(static function (MemberToken $memberToken): array {
                return [
                    'accessModifier' => $memberToken->accessModifier(),
                    'name' => $memberToken->name(),
                    'type' => $memberToken->type()
                ];
            }, $members));

    }

    public function test(): void
    {
        $tokens = token_get_all(<<<EOT
<?php

class Test1
{
    /** @var string */
    public \$parameters;

    public function test(){
        \$anather = "test";
    }
}
EOT
        );

        $members = [];
        foreach ($tokens as $id => $token) {
            if ($token[0] === T_VARIABLE) {
                $members[] = new MemberToken($id, $tokens);
            }
        }

        $this->assertCount(2, $members);
        $expectedData =
            [
                [
                    'accessModifier' => 'public',
                    'name' => '$parameters',
                    'type' => 'string'
                ],

            ];

        $this->assertEquals($expectedData,
            array_map(static function (MemberToken $memberToken): array {
                return [
                    'accessModifier' => $memberToken->accessModifier(),
                    'name' => $memberToken->name(),
                    'type' => $memberToken->type()
                ];
            }, $members));

    }
}


