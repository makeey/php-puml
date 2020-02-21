<?php

namespace PhpUML\Parser\Tokens;

class MemberToken extends VariableToken
{
    /** @var string|null */
    private $accessModifier;
    /** @var string|null */
    private $type;

    public function accessModifier(): ?string
    {
        if ($this->accessModifier === null) {
            $this->accessModifier = $this->parseAccessModifier();
        }
        return $this->accessModifier;
    }

    private function parseAccessModifier(): ?string
    {
        $i = 1;
        $prev = $this->tokens[$this->id - $i];
        while ($prev !== "{" && $prev[0] !== ";" && ($this->id - $i > 0)) {
            if ($prev[0] >= T_PRIVATE && $prev[0] <= T_PUBLIC) {
                return $prev[1];
            }
            $i++;
            $prev = $this->tokens[$this->id - $i];
        }
        return null;
    }

    public function type(): ?string
    {
        if ($this->type === null) {
            $this->type = $this->parseType();
        }
        return $this->type;
    }

    private function parseType(): string
    {
        $i = 1;
        $prev = $this->tokens[$this->id - $i];
        while ($prev !== "{" && $prev !== ";" && ($this->id - $i > 0)) {
            if ($prev[0] === T_DOC_COMMENT) {
                $matches = [];
                if (preg_match("/@var(.*?)\*/m", $prev[1], $matches) !== false) {
                    return trim($matches[1] ?? "");
                }
                return "";
            }
            $i++;
            $prev = $this->tokens[$this->id - $i];
        }
        return  "";
    }
}
