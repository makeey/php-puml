<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;

class MethodFormatter
{
    public static function format(UMLMethod $method): string
    {
        $params = implode(", ", array_map(static function(UMLMethodParameter $parameter){
            return MethodParameterFormatter::format($parameter);
        }, $method->params()));
        return "{$method->methodName()}({$params})" ;
    }
}