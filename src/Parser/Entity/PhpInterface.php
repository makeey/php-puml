<?php

namespace PhpUML\Parser\Entity;

class PhpInterface
{
    /** @var string **/
    private $namespace;
    /** @var string */
    private $interfaceName;
    /** @var PhpMethod[] */
    private $methods;
    /** @var string|null */
    private $parent;

    public function __construct(string $interfaceName, array $methods, string $namespace, ?string $parent)
    {
        $this->interfaceName = $interfaceName;
        $this->namespace = $namespace;
        $this->methods = $methods;
        $this->parent = $parent;
    }

    public function interfaceName(): string
    {
        return $this->interfaceName;
    }

    public function methods(): array
    {
        return $this->methods;
    }

    public function parent(): ?string
    {
        return $this->parent;
    }

    public function namespace(): string
    {
        return $this->namespace;
    }

    public function appendMethods(PhpMethod $method): self
    {
        $this->methods[] = $method;
        return $this;
    }
}
