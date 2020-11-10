<?php declare(strict_types=1);

namespace PhpUML\Tests\Parser\Entity;

use PhpUML\Parser\Entity\PhpClassMember;
use PHPUnit\Framework\TestCase;

class PhpClassMemberTest extends TestCase
{
    public function test__construct(): void
    {
        $name = "name";
        $type = null;
        $accessModifier = "public";
        $classMember = new PhpClassMember($name, $accessModifier, $type);
        $this->assertEquals($name, $classMember->name());
        $this->assertEquals($accessModifier, $classMember->accessModifier());
        $this->assertEquals($type, $classMember->type());
    }
}
