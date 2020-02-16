<?php

namespace PhpUML\Parser\Tokens;

class FunctionToken extends AbstractToken
{
    /** @var array */
    protected $params;
    /** @var string */
    protected $functionName;

    public function functionName(): string
    {
        if ($this->functionName === null) {
            $this->functionName = $this->parseName();
        }
        return $this->functionName;
    }

    protected function parseName(): string
    {
        $next = $this->tokens[$this->id + 1];

        if ($next[0] === T_WHITESPACE) {
            $next = $this->tokens[$this->id + 2];
        }

        if ($next[0] === T_STRING) {
            return $next[1];
        }
        return "";
    }

    public function params(): array
    {
        if ($this->params === null) {
            $i = 4;
            do {
                $next = $this->tokens[$this->id + $i];
                if ($next[0] === T_STRING) {
                    if ($next[1] !== "null") {
                        $this->params[] = [
                            'type' => $next[1],
                            'variable' => $this->tokens[$this->id + $i + 2][1] ?? "bugs"
                        ];
                        $i += 2;
                    }
                }
                if ($next[0] === T_VARIABLE) {
                    $this->params[] = [
                        'type' => 'mixed',
                        'variable' => $next[1]
                    ];
                }
                $i++;
            } while ($next != ")");
            if ($this->params === null) {
                $this->params = [];
            }
        }
        return $this->params;
    }
}