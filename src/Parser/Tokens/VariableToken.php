<?php


namespace PhpUML\Parser\Tokens;


class VariableToken extends AbstractToken
{
    protected $name;

    public function name()
    {
        if($this->name === null)
        {
            $this->name = $this->parseName();
        }
        return $this->name;
    }

    public function parseName()
    {
        return $this->tokens[$this->id][1];
    }
}