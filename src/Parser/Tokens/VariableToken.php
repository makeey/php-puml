<?php


namespace PhpUML\Parser\Tokens;

class VariableToken extends AbstractToken
{
    /** @var string */
    protected $name;

    public function name(): string
    {
        if ($this->name === null) {
            $this->name = $this->parseName();
        }
        return $this->name;
    }

    public function parseName(): string
    {
        return $this->tokens[$this->id][1];
    }
}
