<?php declare(strict_types=1);

namespace PhpUML\UML\Entity;

class UMLMethod
{
    private string $methodName;
    private string $accessModifier;
    /** @var UMLMethodParameter[] */
    private array $params;

    public function __construct(string $methodName, string $accessModifier, UMLMethodParameter ...$params)
    {
        $this->methodName = $methodName;
        $this->accessModifier = $accessModifier;
        $this->params = $params;
    }

    public function methodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return UMLMethodParameter[]
     */
    public function params(): array
    {
        return $this->params;
    }

    public function accessModifier(): string
    {
        return $this->accessModifier;
    }
}
