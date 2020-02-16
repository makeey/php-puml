<?php

namespace PhpUML\Parser\Entity;

class PhpClass
{
    /** @var string */
    private $name;
    /** @var PhpClassMember[] */
    private $properties;
    /** @var PhpMethod[] */
    private $methods;

    public function __construct(string $name, array $properties, array $methods)
    {
        $this->name = $name;
        $this->properties = $properties;
        $this->methods = $methods;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function properties(): array
    {
        return $this->properties;
    }

    public function methods(): array
    {
        return $this->methods;
    }

    public function appendProperties(PhpClassMember $properties): self
    {
        $this->properties[] = $properties;
        return $this;
    }

    public function appendMethods(PhpMethod $method): self
    {
        $this->methods[] = $method;
        return $this;
    }
}