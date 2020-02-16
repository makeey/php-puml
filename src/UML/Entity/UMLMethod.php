<?php

namespace PhpUML\UML\Entity;

class UMLMethod
{
    /** @var string  */
    private $methodName;
    /** @var UMLMethodParameter[] */
    private $params = [];

    public function __construct(string $methodName, UMLMethodParameter ...$params)
    {
        $this->methodName = $methodName;
        $this->params = $params;
    }

    public function methodName()
    {
        return $this->methodName;
    }

    public function params(): array
    {
        return $this->params;
    }
}