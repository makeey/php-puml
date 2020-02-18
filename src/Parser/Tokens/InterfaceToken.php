<?php


namespace PhpUML\Parser\Tokens;


class InterfaceToken extends AbstractToken
{
    /** @var string */
    private $interfaceName;
    /** @var string|null */
    private $parent;

    public function interfaceName(): ?string
    {
        if($this->interfaceName === null) {
            $this->interfaceName = $this->parseInterfaceName();
        }
        return $this->interfaceName;
    }


    public function getParent(): ?string
    {
        return $this->parent;
    }

    private function parseInterfaceName(): ?string
    {
        $next = $this->tokens[$this->id + 1];
        if ($next[0] === T_WHITESPACE) {
            $next = $this->tokens[$this->id + 2];
        }
        if ($next[0] === T_STRING) {
            return $next[1];
        }
        return null;
    }

}