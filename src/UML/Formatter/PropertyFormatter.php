<?php declare(strict_types=1);

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLProperty;

class PropertyFormatter
{
    private AccessModifierFormatter $accessModifierFormatter;

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
