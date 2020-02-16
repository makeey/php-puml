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

    public function mergeDiagram(UMLDiagram $diagram): self
    {
        foreach ($diagram->packages() as $package){
            $this->mergePackage($package, ...$this->packages);
        }
        return $this;
    }

    private function mergePackage(UMLPackage $newPackage, UMLPackage ...$packages)
    {
        $found = false;
        foreach ($packages as $package){
            if($package->name() === $newPackage->name()) {
                $found = true;
                $package->merchePackange($newPackage);
            }
        }
        if($found === false) {
            $this->packages[] = $newPackage;
        }
    }

}