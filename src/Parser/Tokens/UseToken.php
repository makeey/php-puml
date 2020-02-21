<?php

namespace PhpUML\Parser\Tokens;

use Ds\Stack;

class UseToken extends AbstractToken
{
    /** @var string */
    private $fullName;
    /** @var Stack<string> */
    private $parts;

    public function __construct(int $id, array $tokens)
    {
        $this->parts = new Stack();
        parent::__construct($id, $tokens);
    }

    /**
     * @return Stack<string>
     */
    public function parts(): Stack
    {
        if ($this->parts->isEmpty() === true) {
            $this->parseUseStatement();
        }
        return $this->parts;
    }

    private function parseUseStatement(): void
    {
        $i = 0;
        $next = $this->tokens[$this->id + $i];
        $this->fullName = "";
        while ($next !== ";") {
            if ($next[0] === T_STRING) {
                $this->parts->push($next[1]);
                $this->fullName .= $next[1];
            }
            if ($next[0] === T_NS_SEPARATOR) {
                $this->fullName .= "\\\\";
            }
            $i++;
            $next = $this->tokens[$this->id + $i];
        }
    }

    public function fullName(): string
    {
        if ($this->fullName === null) {
            $this->parseUseStatement();
        }
        return $this->fullName;
    }
}
