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
    /** @var UMLInterface[] */
    private $interfaces;

    public function __construct(string $name, array $packages, array $classes, array $interfaces)
    {
        $this->name = $name;
        $this->packages = $packages;
        $this->classes = $classes;
        $this->interfaces = $interfaces;
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

    public function interfaces(): array
    {
        return $this->interfaces;
    }

    public function mergePackage(UMLPackage $package)
    {
        if($package->name() === $this->name) {
            $this->classes = array_merge($this->classes, $package->classes());
            $this->interfaces = array_merge($this->interfaces, $package->interfaces());

            foreach ($package->packages() as $newPackages){
                $found = false;
                foreach ($this->packages as $package) {
                    if($package->name() === $newPackages->name()) {
                        $found = true;
                        $package->mergePackage($newPackages);
                    }
                }
                if($found === false){
                    $this->packages[] = $newPackages;
                }
            }
        }
    }
}
