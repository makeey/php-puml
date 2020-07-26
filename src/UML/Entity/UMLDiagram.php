<?php


namespace PhpUML\UML\Entity;

class UMLDiagram
{
    /** @var UMLNamespace[] */
    private array $namespaces;

    public function __construct(array $namespaces)
    {
        $this->namespaces = $namespaces;
    }

    /**
     * @return UMLNamespace[]
     */
    public function namespaces(): array
    {
        return $this->namespaces;
    }

    public function mergeDiagram(UMLDiagram $diagram): self
    {
        foreach ($diagram->namespaces() as $package) {
            $this->mergeNamespace($package, ...$this->namespaces);
        }
        return $this;
    }

    private function mergeNamespace(UMLNamespace $newPackage, UMLNamespace ...$packages): void
    {
        $found = false;
        foreach ($packages as $package) {
            if ($package->name() === $newPackage->name()) {
                $found = true;
                $package->mergeNamespace($newPackage);
            }
        }
        if ($found === false) {
            $this->namespaces[] = $newPackage;
        }
    }
}
