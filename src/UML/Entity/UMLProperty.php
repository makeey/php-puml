<?php


namespace PhpUML\UML\Entity;

class UMLProperty
{
    private string $name;
    private ?string $type;
    private string $accessModifier;

    public function __construct(string $name, string $accessModifier, ?string $type)
    {
        $this->name = $name;
        $this->accessModifier = $accessModifier;
        $this->type = $type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function accessModifier(): string
    {
        return $this->accessModifier;
    }

    public function type(): ?string
    {
        return $this->type;
    }
}
