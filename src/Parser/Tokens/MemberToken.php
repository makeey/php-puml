<?php


namespace PhpUML\Parser\Tokens;


class MemberToken extends VariableToken
{

    private $accessModifier;
    private $type;

    public function accessModifier(): string
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
        while ($prev != "{" || $prev[0] != ";") {

            if ($prev[0] >= T_PRIVATE && $prev[0] <= T_PUBLIC) {
                return $prev[1];
            }
            $i++;
            $prev = $this->tokens[$this->id - $i];
        }
        return null;
    }
}