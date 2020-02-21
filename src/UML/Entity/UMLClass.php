<?php

namespace PhpUML\UML\Entity;

class UMLClass
{
    /** @var string */
    private $className;
    /** @var UMLMethod[] */
    private $methods;
    /** @var UMLProperty[] */
    private $properties;
    /** @var string|null */
    private $extends;
    /** @var string[] */
    private $implements;
    /** @var string|null */
    private $namespace;

    /**
     * UMLClass constructor.
     * @param string $className
     * @param UMLMethod[] $methods
     * @param UMLProperty[] $properties
     * @param string|null $extends
     * @param string|null $namespaces
     * @param string[] $implements
     */
    public function __construct(
        string $className,
        array $methods,
        array $properties,
        ?string $extends = null,
        ?string $namespaces = null,
        array $implements = []
    ) {
        $this->namespace = $namespaces;
        $this->className = $className;
        $this->methods = $methods;
        $this->properties = $properties;
        $this->extends = $extends;
        $this->implements = $implements;
    }

    public function className(): string
    {
        return $this->className;
    }

    public function extends(): ?string
    {
        return $this->extends;
    }

    /**
     * @return UMLMethod[]
     */
    public function methods(): array
    {
        return $this->methods;
    }

    /**
     * @return UMLProperty[]
     */
    public function properties(): array
    {
        return $this->properties;
    }

    /**
     * @return string[]
     */
    public function implements(): array
    {
        return $this->implements;
    }

    public function namespace(): ?string
    {
        return $this->namespace;
    }
}
