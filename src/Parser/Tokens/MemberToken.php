<?php

namespace PhpUML\Parser\Tokens;

class MemberToken extends VariableToken
{
    private ?string $accessModifier = null;
    private ?string $type = null;

    public function accessModifier(): string
    {
        if ($this->accessModifier === null) {
            $this->accessModifier = $this->parseAccessModifier();
        }
        return $this->accessModifier;
    }

    private function parseAccessModifier(): string
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
        return 'public';
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
            } else {
                if ($prev[0] === T_ARRAY) {
                    return $prev[1];
                } else {
                    if ($prev[0] === T_STRING) {
                        if ($this->tokens[$this->id - $i - 1][0] == T_NS_SEPARATOR) {
                            return $this->resolveFullTypeForTypedProperty($i);
                        } else {
                            return $prev[1];
                        }
                    }
                }
            }
            $i++;
            $prev = $this->tokens[$this->id - $i];
        }
        return "";
    }

    private function resolveFullTypeForTypedProperty(int $i, string $res = ''): string
    {
        if ($this->id - $i <= 0) {
            return $res;
        }
        $prev = $this->tokens[$this->id - $i];
        if ($prev[0] == T_STRING) {
            return $this->resolveFullTypeForTypedProperty($i + 1, $prev[1] . $res);
        };
        if ($prev[0] == T_NS_SEPARATOR) {
            return $this->resolveFullTypeForTypedProperty($i + 1, '\\' . $res);
        }

        return $res;
    }
}
