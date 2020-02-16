<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLProperty;

class PropertyFormatter
{
    public static function format(UMLProperty $property): string
    {
        $accessModifier = self::resolveAccessModifier($property->accessModifier());
        return "{$accessModifier} {$property->name()}: {$property->type()}";
    }

    private static function resolveAccessModifier(string $modifier): string
    {
        switch ($modifier) {
            case "public":
                return "+";
            case "private" :
                return "-";
            case "protected":
                return "#";
            default:
                return "";
        }
    }
}