<?php declare(strict_types=1);

namespace PhpUML\Parser\Entity;

final class PhpClassMember
{
    private ?string $type;
    private string $name;
    private string $accessModifier;

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
