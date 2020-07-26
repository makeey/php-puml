<?php

namespace PhpUML\Parser\Tokens;

abstract class AbstractToken
{
    protected int $id;
    protected array $tokens;

    public function __construct(int $id, array $tokens)
    {
        $this->id = $id;
        $this->tokens = $tokens;
    }
}
