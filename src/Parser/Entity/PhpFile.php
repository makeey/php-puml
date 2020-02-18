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
}