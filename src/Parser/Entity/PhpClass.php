<?php

namespace PhpUML\Parser\Entity;

final class PhpClass
{
    private string $namespace;
    private string $name;
    /** @var PhpClassMember[] */
    private array $properties;
    /** @var PhpMethod[] */
    private array $methods;
    private ?string $parent;
    /** @var string[] */
    private array $implements;

    public function __construct(
        string $name,
        array $properties,
        array $methods,
        string $namespace,
        ?string $parent = null,
        array $implements = []
    ) {
        $this->name = $name;
        $this->properties = $properties;
        $this->methods = $methods;
        $this->namespace = $namespace;
        $this->parent = $parent;
        $this->implements = $implements;
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

    public function implements(): array
    {
        return $this->implements;
    }
}
