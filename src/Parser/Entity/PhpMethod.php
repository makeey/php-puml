<?php

namespace PhpUML\Parser\Entity;

class PhpMethod
{
    /** @var string */
    private $name;
    /** @var PhpMethodParameter[] */
    private $parameters;

    public function __construct(string $name, array $parameters)
    {
        $this->name = $name;
        $this->parameters = $parameters;
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