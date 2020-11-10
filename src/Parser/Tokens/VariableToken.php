<?php declare(strict_types=1);


namespace PhpUML\Parser\Tokens;

class VariableToken extends AbstractToken
{
    protected ?string $name = null;

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
