<?php


namespace PhpUML\Entity;


class UMLMethod
{
    private $methodName;

    public function __construct(string $methodName)
    {
        $this->methodName = $methodName;
    }

    public function methodName()
    {
        return $this->methodName;
    }
}