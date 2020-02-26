<?php

namespace PhpUML\Tests\UML\Formatter;

use PhpUML\UML\Formatter\AccessModifierFormatter;
use PHPUnit\Framework\TestCase;

class AccessModifierFormatterTest extends TestCase
{
    public function testResolveAccessModifier():void
    {
        $resolver = new AccessModifierFormatter();
        $resolvedPrivate = "-";
        $resolvedPublic = "+";
        $resolvedProtected = "#";

        $this->assertEquals($resolvedPrivate, $resolver->resolveAccessModifier('private'));
        $this->assertEquals($resolvedPublic, $resolver->resolveAccessModifier('public'));
        $this->assertEquals($resolvedProtected, $resolver->resolveAccessModifier('protected'));
        $this->assertEquals('', $resolver->resolveAccessModifier('unknown'));
    }
}
