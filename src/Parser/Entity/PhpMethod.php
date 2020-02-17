<?php

namespace PhpUML\Parser\Entity;

class PhpMethod
{
    /** @var string */
    private $name;
    /** @var PhpMethodParameter[] */
    private $parameters;
    /** @var string */
    private $accessModifier;

    public function __construct(string $name, array $parameters, string $accessModifier)
    {
        $this->name = $name;
        $this->parameters = $parameters;
        $this->accessModifier = $accessModifier;
    }

    public function accessModifier(): string
    {
        return $this->accessModifier;
    }
    public function name(): string
    {
        return $this->name;
    }

    /** @return PhpMethodParameter[] */
    public function parameters(): array
    {
        return $this->parameters;
    }
}