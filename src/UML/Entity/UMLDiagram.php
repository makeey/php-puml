<?php


namespace PhpUML\UML\Entity;


class UMLDiagram
{
    /** @var UMLPackage[] */
    private $packages;

    public function __construct(array $packages)
    {
        $this->packages = $packages;
    }

    public function packages(): array
    {
        return $this->packages;
    }
}