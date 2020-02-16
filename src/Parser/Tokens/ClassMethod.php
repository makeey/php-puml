<?php

namespace PhpUML\Parser\Tokens;

class ClassMethod extends FunctionToken
{
    /** @var string */
    private $accessModifier;

    public function accessModifier(): string
    {
        if($this->accessModifier === null){
            $this->accessModifier = $this->parseAccessModifier();
        }
        return $this->accessModifier;
    }

    private function parseAccessModifier(): string
    {
        $i = 0;
        $prev = $this->tokens[$this->id - $i];
        while ($prev != "}" && $prev != ";" && $prev != "{")
        {
            if ($prev[0] >= T_PRIVATE && $prev[0] <= T_PUBLIC) {
                return $prev[1];
            }
            $i++;
            $prev = $this->tokens[$this->id - $i];
        }
        return 'public';

    }
}