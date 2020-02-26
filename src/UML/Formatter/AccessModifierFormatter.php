<?php


namespace PhpUML\UML\Formatter;

class AccessModifierFormatter
{
    public function resolveAccessModifier(string $modifier): string
    {
        switch ($modifier) {
            case "public":
                return "+";
            case "private":
                return "-";
            case "protected":
                return "#";
            default:
                return "";
        }
    }
}
