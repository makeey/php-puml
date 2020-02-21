<?php

namespace PhpUML\UML\Entity;

class UMLMethod
{
    /** @var string  */
    private $methodName;
    /** @var string */
    private $accessModifier;
    /** @var UMLMethodParameter[] */
    private $params;

    public function __construct(string $methodName, string $accessModifier, UMLMethodParameter ...$params)
    {
        $this->methodName = $methodName;
        $this->accessModifier = $accessModifier;
        $this->params = $params;
    }

    public function methodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return UMLMethodParameter[]
     */
    public function params(): array
    {
        return $this->params;
    }

    public function accessModifier(): string
    {
        return $this->accessModifier;
    }
}
