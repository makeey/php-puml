<?php declare(strict_types=1);

namespace PhpUML\Parser\Tokens;

use Ds\Stack;

class UseToken extends AbstractToken
{
    private ?string $fullName = null;
    /** @var Stack<string> */
    private Stack $parts;

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

    private function parseUseStatement(): string
    {
        $i = 0;
        $next = $this->tokens[$this->id + $i];
        $fullName = "";
        $fullName = "";
        while ($next !== ";") {
            if ($next[0] === T_STRING) {
                $this->parts->push($next[1]);
                $fullName .= $next[1];
            }
            if ($next[0] === T_NS_SEPARATOR) {
                $fullName .= "\\\\";
            }
            $i++;
            $next = $this->tokens[$this->id + $i];
        }
        return $fullName;
    }

    public function fullName(): string
    {
        if ($this->fullName === null) {
            $this->fullName = $this->parseUseStatement();
        }
        return $this->fullName;
    }
}
