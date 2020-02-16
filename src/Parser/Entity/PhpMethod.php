<?php

namespace PhpUML\Parser\Entity;

class PhpMethod
{
    /** @var string */
    private $name;
    /** @var PhpMethodParameter[] */
    private $parameters;
    /** @var string */
    private $acessModifier;

    public function __construct(string $name, array $parameters, string $accessModifier)
    {
        $this->name = $name;
        $this->parameters = $parameters;
        $this->acessModifier = $accessModifier;
    }

    public function accessModifier(): string
    {
        return $this->acessModifier;
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