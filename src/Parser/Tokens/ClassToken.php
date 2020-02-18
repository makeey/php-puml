<?php


namespace PhpUML\Parser\Tokens;

class ClassToken extends AbstractToken
{
    /** @var string */
    private $className;
    /** @var string */
    private $parent;
    /** @var string[] */
    private $interfaces;

    public function className()
    {
        if ($this->className === null) {
            $this->className = $this->parseClassName();
        }
        return $this->className;
    }

    private function parseClassName(): ?string
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

    public function parent(): ?string
    {
        if ($this->parent === null) {
            $this->parent = $this->parseParent();
        }
        return $this->parent;
    }

    private function parseParent(): ?string
    {
        $i = $this->id + 1;
        $next = $this->tokens[$i];
        $className = null;
        $isExtending = false;
        while ($next != "{") {
            if ($next[0] === T_IMPLEMENTS) {
                break;
            }
            if ($next[0] === T_EXTENDS) {
                $className = $this->tokens[$i + 2][1];
                $isExtending = true;
                $i += 2;
            }
            if ($next[0] === T_NS_SEPARATOR && $isExtending) {
                $className .= "\\\\";
            }
            if ($next[0] === T_STRING && $isExtending) {
                $className .= $next[1];
            }
            $i++;
            $next = $this->tokens[$i];
        }
        return $className;
    }

    public function interfaces(): array
    {
        if ($this->interfaces === null) {
            $this->interfaces = $this->parseInterfaces();
        }
        return $this->interfaces;
    }

    private function parseInterfaces()
    {
        $i = $this->id + 1;
        $next = $this->tokens[$i];
        $interfaces = [];
        $isImplementing = false;
        while ($next != "{") {
            if ($next[0] === T_IMPLEMENTS) {
                $isImplementing = true;
            }
            if ($isImplementing && $next[0] === T_STRING) {
                $interfaces[] = $this->tokens[$i][1];
            }
            $i++;
            $next = $this->tokens[$i];
        }
        return $interfaces;
    }
}