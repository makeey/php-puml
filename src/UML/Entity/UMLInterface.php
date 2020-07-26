<?php


namespace PhpUML\UML\Entity;

class UMLInterface
{
    private string $name;
    /** @var UMLMethod[] **/
    private array $methods;

    /**
     * UMLInterface constructor.
     * @param string $name
     * @param UMLMethod[] $methods
     */
    public function __construct(string $name, array $methods)
    {
        $this->name = $name;
        $this->methods = $methods;
    }

    /**
     * @return UMLMethod[]
     */
    public function methods(): array
    {
        return $this->methods;
    }

    public function name(): string
    {
        return $this->name;
    }
}
