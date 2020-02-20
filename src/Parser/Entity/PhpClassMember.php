<?php

namespace PhpUML\Parser\Entity;

class PhpClassMember
{
    /** @var string|null */
    private $type;
    /** @var string */
    private $name;
    /** @var string */
    private $accessModifier;

    public function __construct(string $name, string $accessModifier, ?string $type)
    {
        $this->type = $type;
        $this->name = $name;
        $this->accessModifier = $accessModifier;
    }

    public function type(): ?string
    {
        return $this->type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function accessModifier(): string
    {
        return $this->accessModifier;
    }
}
