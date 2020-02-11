<?php


namespace PhpUML\Entity;


class UMLClass implements \JsonSerializable
{
    private $className;

    /** @var array */
    private $methods;
    /** @var array */
    private $properties;

    public function __construct(string $className, array $methods, array $properties)
    {
        $this->className = $className;
    }

    public function jsonSerialize()
    {
       return [
           'className' => $this->className,
       ];
    }

    public function className()
    {
        return $this->className;
    }
}