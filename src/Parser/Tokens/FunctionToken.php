<?php declare(strict_types=1);

namespace PhpUML\Parser\Tokens;

class FunctionToken extends AbstractToken
{
    /** @var array */
    private static $DEFAULT_VALUE_FOR_TYPES = ['null', 'true', 'false', '[', ']'];
    protected ?array $params = null;
    protected ?string $functionName = null;

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

        /**
         * The situation when the function name intersect with php keywords (ex. namespace)
         */
        return $next[1];
    }

    public function params(): array
    {
        if ($this->params === null) {
            $i = 4;

            do {
                $next = $this->tokens[$this->id + $i];
                if ($next[0] === T_STRING || $next[0] === T_ARRAY) {
                    if (in_array($next[1], self::$DEFAULT_VALUE_FOR_TYPES, true) === false) {
                        if (isset($this->tokens[$this->id + $i + 2][1]) && $this->tokens[$this->id + $i + 2][1] === "...") {
                            $this->params[] = [
                                'type' => $next[1] . "[]",
                                'variable' => $this->tokens[$this->id + $i + 3][1] ?? "bugs"
                            ];
                            $i += 3;
                        } else {
                            if (isset($this->tokens[$this->id + $i + 2][1])) {
                                $this->params[] = [
                                    'type' => $next[1],
                                    'variable' => $this->tokens[$this->id + $i + 2][1]
                                ];
                                $i += 2;
                            } else {
                                $this->params[] = [
                                    'type' => $next[1],
                                    'variable' => $this->tokens[$this->id + $i + 2] . $this->tokens[$this->id + $i + 3][1]
                                ];
                                $i += 3;
                            }
                        }
                    }
                }
                if ($next[0] === T_VARIABLE) {
                    $this->params[] = [
                        'type' => 'mixed',
                        'variable' => $next[1]
                    ];
                }
                $i++;
            } while ($next != ")" && $this->id + $i < count($this->tokens));
            if ($this->params === null) {
                $this->params = [];
            }
        }
        return $this->params;
    }
}
