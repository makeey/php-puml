<?php

namespace PhpUML\Parser;

use Ds\Stack;
use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpMethod;
use PhpUML\Parser\Entity\PhpMethodParameter;
use PhpUML\Parser\Tokens\ClassMethod;
use PhpUML\Parser\Tokens\ClassToken;
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
    /** @var Stack */
    private $controlStructure;

    public function __construct()
    {
        $this->classes = new Stack();
        $this->methods = new Stack();
        $this->functions = new Stack();
        $this->controlStructure = new Stack();
        $this->file = new PhpFile();
    }

    public function __invoke(string $phpSourceCode): PhpFile
    {
        $this->classes = new Stack();
        $this->methods = new Stack();
        $this->functions = new Stack();
        $this->controlStructure = new Stack();
        $this->file = new PhpFile();
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
                case T_IF:
                case T_FOR:
                case T_FOREACH:
                case T_ELSE:
                case T_WHILE:
                case T_DO:
                    $this->processControlStructure($id, $tokens);
                    break;
                case "}":
                    $this->processCloseBrackets();
                    break;
            }
        }
        return $this->file;
    }

    private function processNameSpace(int $id, array $tokens): void
    {
        $namespaceToken = new NameSpaceToken($id, $tokens);
        $this->file->setNameSpace($namespaceToken->name());
    }

    private function processClassToken(int $id, array $tokens): void
    {
        if ($this->classes->isEmpty() === true) {
            $phpClassToken = new ClassToken($id, $tokens);
            $this->classes->push(new PhpClass($phpClassToken->className(), [], [], $phpClassToken->parent()));
        }
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
            if ($this->methods->isEmpty() === true) {
                $methodToken = new ClassMethod($id, $tokens);
                $this->methods->push(new PhpMethod($methodToken->functionName(),
                    array_map(
                        static function (array $parameter): PhpMethodParameter {
                            return new PhpMethodParameter(
                                $parameter['variable'],
                                $parameter['type']
                            );
                        },
                        $methodToken->params()
                    ),
                    $methodToken->accessModifier()
                ));
            } else {
                $this->controlStructure->push($tokens[0]);
            }
        } else {
            $this->functions->push("function not implemented");
        }
    }

    private function processControlStructure(int $id, array $tokens): void
    {
        if ($tokens[$id][0] === T_WHILE && $this->controlStructure->peek() === T_DO) {
            $this->controlStructure->pop();
            return;
        }
        $this->controlStructure->push($tokens[$id][0]);
    }

    private function processCloseBrackets(): void
    {
        if ($this->controlStructure->isEmpty() === false && $this->controlStructure->peek() !== T_DO) {
            $this->controlStructure->pop();
            return;
        }

        if ($this->classes->isEmpty() === false && $this->methods->isEmpty()) {
            $this->file->appendClass($this->classes->pop());
        }

        if ($this->classes->isEmpty() === false && $this->methods->isEmpty() === false) {
            ($this->classes->peek())->appendMethods(
                $this->methods->pop()
            );
        }
    }
}