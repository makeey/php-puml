<?php

namespace PhpUML\Parser\Entity;

class PhpFile
{
    /** @var string */
    private $namespace;
    /** @var PhpClass */
    private $classes = [];
    /** @var PhpInterface[] */
    private $interfaces = [];
    /** @var array */
    private $usedClasses;

    public function __construct()
    {
        $this->interfaces = [];
        $this->classes = [];
    }

    public function appendClass(PhpClass $class): self
    {
        $this->classes[] = $class;
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

    public function appendUsedClass(array $usedClass): self
    {
        if (array_key_exists('name', $usedClass) === false ||
            array_key_exists('fullName', $usedClass) === false
        ) {
            throw new \InvalidArgumentException("Wrong format for used classes. Array must contains name and fullName");
        }
        $this->usedClasses[] = $usedClass;
        return $this;
    }
}