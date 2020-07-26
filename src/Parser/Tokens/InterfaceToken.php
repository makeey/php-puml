<?php


namespace PhpUML\Parser\Tokens;

final class InterfaceToken extends AbstractToken
{
    private ?string $interfaceName = null;
    private ?string $parent = null;

    public function interfaceName(): string
    {
        if ($this->interfaceName === null) {
            $this->interfaceName = $this->parseInterfaceName();
        }
        return $this->interfaceName;
    }

    private function parseInterfaceName(): string
    {
        $next = $this->tokens[$this->id + 1];
        if ($next[0] === T_WHITESPACE) {
            $next = $this->tokens[$this->id + 2];
        }

        return $next[1];
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }
}
