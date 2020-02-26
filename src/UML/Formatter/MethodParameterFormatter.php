<?php


namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLMethodParameter;

class MethodParameterFormatter
{
    public function format(UMLMethodParameter $parameter):  string
    {
        return "{$parameter->name()}: {$parameter->type()}";
    }
}
