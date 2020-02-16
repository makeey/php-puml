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

    public function merchePackange(UMLPackage $package)
    {
        if($package->name() === $this->name) {
            $this->classes = array_merge($this->classes, $package->classes());

            foreach ($package->packages() as $newPackages){
                $found = false;
                foreach ($this->packages as $package) {
                    if($package->name() === $newPackages->name()) {
                        $found = true;
                        $package->merchePackange($newPackages);
                    }
                }
                if($found === false){
                    $this->packages[] = $newPackages;
                }
            }
        }
    }
}
