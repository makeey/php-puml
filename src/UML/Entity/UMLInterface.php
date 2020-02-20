<?php


namespace PhpUML\UML\Entity;

class UMLInterface
{
    /** @var string **/
    private $name;
    /** @var UMLMethod[] **/
    private $methods;

    public function __construct(string $name, array $methods)
    {
        $this->name = $name;
        $this->methods = $methods;
    }

    public function methods(): array
    {
        return $this->methods;
    }

    public function name(): string
    {
        return $this->name;
    }
}
