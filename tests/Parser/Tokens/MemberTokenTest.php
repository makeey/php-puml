<?php


class MemberTokenTest extends \PHPUnit\Framework\TestCase
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
                $members[] = new \PhpUML\Parser\Tokens\MemberToken($id, $tokens);
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
            array_map(static function (\PhpUML\Parser\Tokens\MemberToken $memberToken): array {
                return [
                    'accessModifier' => $memberToken->accessModifier(),
                    'name' => $memberToken->name()
                ];
            }, $members));

    }
}