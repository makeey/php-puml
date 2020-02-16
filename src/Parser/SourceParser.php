<?php

namespace PhpUML\Parser;

use Ds\Stack;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpMethod;
use PhpUML\Parser\Entity\PhpMethodParameter;
use PhpUML\Parser\Tokens\ClassToken;
use PhpUML\Parser\Tokens\FunctionToken;
use PhpUML\Parser\Tokens\MemberToken;
use PhpUML\Parser\Tokens\NameSpaceToken;

class SourceParser
{
    /** @var PhpFile */
    private $file;
    /** @var Stack */
    private $classes;
    /** @var Stack */
    private $methods;
    /** @var Stack */
    private $functions;

    public function __construct()
    {
        $this->classes = new Stack();
        $this->methods = new Stack();
        $this->functions = new Stack();
        $this->file = new PhpFile();
    }

    public function __invoke(string $phpSourceCode): PhpFile
    {
        $tokens = token_get_all($phpSourceCode);
        foreach ($tokens as $id => $token) {
            switch ($token[0]) {
                case T_NAMESPACE:
                    $this->processNameSpace($id, $tokens);
                    break;
                case T_CLASS:
                    $this->processClassToken($id, $tokens);
                    break;
                case T_VARIABLE:
                    $this->processVariableToken($id, $tokens);
                    break;
                case T_FUNCTION:
                    $this->processFunctionToken($id, $tokens);
                    break;
                case "}":
                    $this->processCloseBrackets();
                    break;
            }
        }
        return $this->file;
    }

    private function processClassToken(int $id, array $tokens): void
    {
        $phpClassToken = new ClassToken($id, $tokens);
        $this->classes->push(new PhpClass($phpClassToken->className(), [], []));
    }

    private function processVariableToken(int $id, array $tokens): void
    {
        if ($this->classes->isEmpty() === false && $this->methods->isEmpty()) {
            $memberToken = new MemberToken($id, $tokens);
            ($this->classes->peek())->appendProperties(
                new PhpClassMember(
                    $memberToken->name(),
                    $memberToken->accessModifier(),
                    $memberToken->type()
                )
            );
        }
    }

    private function processFunctionToken(int $id, array $tokens): void
    {
        if ($this->classes->isEmpty() === false) {
            $methodToken = new FunctionToken($id, $tokens);
            $this->methods->push(new PhpMethod($methodToken->functionName(),
                array_map(
                    static function (array $parameter): PhpMethodParameter {
                        return new PhpMethodParameter(
                            $parameter['variable'],
                            $parameter['type']
                        );
                    },
                    $methodToken->params()
                )));
        } else {
            $this->functions->push("function not implemented");
        }
    }

    private function processCloseBrackets(): void
    {
        if ($this->classes->isEmpty() === false && $this->methods->isEmpty() === false) {
            ($this->classes->peek())->appendMethods(
                $this->methods->pop()
            );
        }
        if ($this->classes->isEmpty() === false && $this->methods->isEmpty()) {
            $this->file->appendClass($this->classes->pop());
        }
    }

    private function processNameSpace(int $id, array $tokens): void
    {
        $namespaceToken = new NameSpaceToken($id, $tokens);
        $this->file->setNameSpace($namespaceToken->name());
    }
}