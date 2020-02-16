<?php

namespace PhpUML\Parser\Tokens;

class AbstractToken
{
    protected $id;
    protected $tokens;

    public function __construct(int $id, array $tokens)
    {
        $this->id = $id;
        $this->tokens = $tokens;
    }
}