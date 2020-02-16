<?php


namespace PhpUML\UML\Entity;


class UMLPackage
{
    /** @var string */
    private $name;

    /** @var UMLPackage[] */
    private $packages;

    /** @var UMLClass[] */
    private $classes;

    public function __construct(string $name, array $packages, array $classes)
    {
        $this->name = $name;
        $this->packages = $packages;
        $this->classes = $classes;
    }

    public function packages(): array
    {
        return $this->packages;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function classes(): array
    {
        return $this->classes;
    }
}
