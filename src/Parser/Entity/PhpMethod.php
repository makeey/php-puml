<?php declare(strict_types=1);

namespace PhpUML\Parser\Entity;

final class PhpMethod
{
    private string $name;
    /** @var PhpMethodParameter[] */
    private array $parameters;
    private string $accessModifier;

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
