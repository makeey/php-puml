<?php

namespace PhpUML\Parser\Entity;

final class PhpMethodParameter
{
    private const DEFAULT_TYPE = 'mixed';
    private string $name;
    private string $type;

    public function __construct(string $name, ?string $type)
    {
        $this->name = $name;
        $this->type = $type ?? self::DEFAULT_TYPE;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }
}
