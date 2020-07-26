<?php


namespace PhpUML\UML\Entity;

class UMLNamespace
{
    private string $name;
    /** @var UMLNamespace[] */
    private array $namespaces;
    /** @var UMLClass[] */
    private array $classes;
    /** @var UMLInterface[] */
    private array $interfaces;

    /**
     * UMLNamespace constructor.
     * @param string $name
     * @param UMLNamespace[] $namespaces
     * @param UMLClass[] $classes
     * @param UMLInterface[] $interfaces
     */
    public function __construct(string $name, array $namespaces, array $classes, array $interfaces)
    {
        $this->name = $name;
        $this->namespaces = $namespaces;
        $this->classes = $classes;
        $this->interfaces = $interfaces;
    }

    /**
     * @return UMLNamespace[]
     */
    public function namespaces(): array
    {
        return $this->namespaces;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return UMLClass[]
     */
    public function classes(): array
    {
        return $this->classes;
    }

    /**
     * @return UMLInterface[]
     */
    public function interfaces(): array
    {
        return $this->interfaces;
    }

    public function mergeNamespace(UMLNamespace $leftNamespace): void
    {
        if ($leftNamespace->name() === $this->name) {
            $this->classes = array_merge($this->classes, $leftNamespace->classes());
            $this->interfaces = array_merge($this->interfaces, $leftNamespace->interfaces());

            foreach ($leftNamespace->namespaces() as $newNamespace) {
                $found = false;
                foreach ($this->namespaces as $namespace) {
                    if ($namespace->name() === $newNamespace->name()) {
                        $found = true;
                        $namespace->mergeNamespace($newNamespace);
                    }
                }
                if ($found === false) {
                    $this->namespaces[] = $newNamespace;
                }
            }
        }
    }
}
