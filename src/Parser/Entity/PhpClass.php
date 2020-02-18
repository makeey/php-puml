<?php

namespace PhpUML\Parser\Entity;

class PhpClass
{
    /** @var string */
    private $namespace;
    /** @var string */
    private $name;
    /** @var PhpClassMember[] */
    private $properties;
    /** @var PhpMethod[] */
    private $methods;
    /** @var string|null */
    private $parent;

    public function __construct(string $name, array $properties, array $methods, string $namespace, ?string $parent = null)
    {
        $this->name = $name;
        $this->properties = $properties;
        $this->methods = $methods;
        $this->namespace = $namespace;
        $this->parent = $parent;
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

    public function parent(): ?string
    {
        return $this->parent;
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

    public function namespace(): string
    {
        return $this->namespace;
    }
}