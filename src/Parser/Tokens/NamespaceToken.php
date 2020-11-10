<?php declare(strict_types=1);

namespace PhpUML\Parser\Tokens;

class NamespaceToken extends AbstractToken
{
    private ?string $name = null;

    public function name(): string
    {
        if ($this->name === null) {
            $this->name = $this->parseName();
        }
        return $this->name;
    }

    private function parseName(): string
    {
        $i = 1;
        $next = $this->tokens[$this->id + $i];
        $namespace = "";
        while ($next != ";" && $next != '{') {
            if ($next[0] === T_STRING) {
                $namespace .= $next[1];
            }
            if ($next[0] === T_NS_SEPARATOR) {
                $namespace .= "\\\\";
            }
            $next = $this->tokens[$this->id + $i];
            $i++;
        }
        return $namespace;
    }
}
