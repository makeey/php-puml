<?php


namespace PhpUML\UML\Entity;

class UMLNamespace
{
    /** @var string */
    private $name;
    /** @var UMLNamespace[] */
    private $namespaces;
    /** @var UMLClass[] */
    private $classes;
    /** @var UMLInterface[] */
    private $interfaces;

    public function __construct(string $name, array $namespaces, array $classes, array $interfaces)
    {
        $this->name = $name;
        $this->namespaces = $namespaces;
        $this->classes = $classes;
        $this->interfaces = $interfaces;
    }

    public function namespaces(): array
    {
        return $this->namespaces;
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

    public function mergeNamespace(UMLNamespace $namespace)
    {
        if ($namespace->name() === $this->name) {
            $this->classes = array_merge($this->classes, $namespace->classes());
            $this->interfaces = array_merge($this->interfaces, $namespace->interfaces());

            foreach ($namespace->namespaces() as $newNamespace) {
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
