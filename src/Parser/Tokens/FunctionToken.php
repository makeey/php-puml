<?php

namespace PhpUML\Parser\Tokens;

class FunctionToken
{
    private $id;
    private $params;
    private $functionName;
    private $tokens;

    public function __construct(int $id, array $tokens)
    {
        $this->id = $id;
        $this->tokens = $tokens;
    }

    public function functionName(): string
    {
        if($this->functionName === null) {
            $this->functionName = $this->parseName();
        }
        return $this->functionName;
    }

    private function parseName(): string
    {
        $next = $this->tokens[$this->id +1];

        if($next[0] === T_WHITESPACE) {
            $next = $this->tokens[$this->id +2];
        }

        if($next[0] === T_STRING) {
           return $next[1];
        }
        return "";
    }

    public function params(): array
    {
        if($this->params === null)
        {
            $i = 4;
            do{
                $next = $this->tokens[$this->id + $i];
                if($next[0] === T_STRING) {
                    $this->params[] = [
                        'type' => $next[1],
                        'variable' => $this->tokens[$this->id + $i + 2][1]
                    ];
                    $i +=2;
                }
                $i++;
            }while($next != ")");
        }
        return $this->params;
    }
}