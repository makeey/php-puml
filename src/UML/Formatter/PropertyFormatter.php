<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLProperty;

class PropertyFormatter
{
    /** @var AccessModifierFormatter */
    private $accessModifierFormatter;

    public function __construct(AccessModifierFormatter $accessModifierFormatter)
    {
        $this->accessModifierFormatter = $accessModifierFormatter;
    }

    public function format(UMLProperty $property): string
    {
        $accessModifier = $this->accessModifierFormatter->resolveAccessModifier($property->accessModifier());
        return "{$accessModifier} {$property->name()}: {$property->type()}";
    }
}
