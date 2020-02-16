<?php


namespace PhpUML\UML\Entity;


class UMLMethodParameter
{
    /** @var string */
    private $name;
    /** @var string **/
    private $type;

    public function __construct(string $name, string $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function type(): string
    {
        return $this->type;
    }
}