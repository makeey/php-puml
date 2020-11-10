<?php declare(strict_types=1);

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;

class MethodFormatter
{
    /** @var AccessModifierFormatter */
    private AccessModifierFormatter $accessModifierFormatter;
    /** @var MethodParameterFormatter */
    private MethodParameterFormatter $methodParametersFormatter;

    public function __construct(AccessModifierFormatter $accessModifierFormatter, MethodParameterFormatter $methodParameterFormatter)
    {
        $this->accessModifierFormatter = $accessModifierFormatter;
        $this->methodParametersFormatter = $methodParameterFormatter;
    }

    public function format(UMLMethod $method): string
    {
        $params = implode(", ", array_map(function (UMLMethodParameter $parameter): string {
            return $this->methodParametersFormatter->format($parameter);
        }, $method->params()));
        $accessModifier = $this->resolveAccessModifier($method->accessModifier());
        return "{$accessModifier} {$method->methodName()}({$params})";
    }

    private function resolveAccessModifier(string $modifier): string
    {
        return $this->accessModifierFormatter->resolveAccessModifier($modifier);
    }
}
