<?php


namespace PhpUML\UML\Entity;

class UMLInterface
{
    /** @var string **/
    private $name;
    /** @var UMLMethod[] **/
    private $methods;

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
