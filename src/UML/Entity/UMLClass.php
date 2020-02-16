<?php

namespace PhpUML\UML\Entity;

class UMLClass
{
    /** @var string  */
    private $className;
    /** @var UMLMethod[] */
    private $methods;
    /** @var UMLProperty[] */
    private $properties;

    public function __construct(string $className, array $methods, array $properties)
    {
        $this->className = $className;
        $this->methods = $methods;
        $this->properties = $properties;
    }

    public function className()
    {
        return $this->className;
    }

    public function methods(): array
    {
        return $this->methods;
    }

    public function properties(): array
    {
        return $this->properties;
    }
}