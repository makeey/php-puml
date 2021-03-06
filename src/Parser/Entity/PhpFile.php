<?php declare(strict_types=1);

namespace PhpUML\Parser\Entity;

use InvalidArgumentException;

class PhpFile
{
    private ?string $namespace = null;
    /** @var PhpClass[] */
    private array $classes = [];
    /** @var PhpInterface[] */
    private array $interfaces = [];
    private array $usedClasses = [];

    public function appendClasses(PhpClass ...$classes): self
    {
        foreach ($classes as $class) {
            $this->appendClass($class);
        }
        return $this;
    }

    public function appendClass(PhpClass $class): self
    {
        $this->classes[] = $class;
        return $this;
    }

    public function appendInterfaces(PhpInterface ...$interfaces): self
    {
        foreach ($interfaces as $interface) {
            $this->appendInterface($interface);
        }
        return $this;
    }

    public function appendInterface(PhpInterface $interface): self
    {
        $this->interfaces[] = $interface;
        return $this;
    }


    public function setNameSpace(string $namespace): self
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function classes(): array
    {
        return $this->classes;
    }

    public function interfaces(): array
    {
        return $this->interfaces;
    }

    public function namespace(): ?string
    {
        return $this->namespace;
    }

    public function usedClasses(): array
    {
        return $this->usedClasses;
    }

    public function appendUsedClasses(array $usedClasses): self
    {
        foreach ($usedClasses as $usedClass) {
            $this->appendUsedClass($usedClass);
        }
        return $this;
    }

    public function appendUsedClass(array $usedClass): self
    {
        if (array_key_exists('name', $usedClass) === false ||
            array_key_exists('fullName', $usedClass) === false
        ) {
            throw new InvalidArgumentException("Wrong format for used classes. Array must contains name and fullName");
        }
        $this->usedClasses[] = $usedClass;
        return $this;
    }
}
