<?php

namespace PhpUML\Parser;

use Ds\Stack;
use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpInterface;
use PhpUML\Parser\Entity\PhpMethod;
use PhpUML\Parser\Entity\PhpMethodParameter;
use PhpUML\Parser\Tokens\ClassMethod;
use PhpUML\Parser\Tokens\ClassToken;
use PhpUML\Parser\Tokens\InterfaceToken;
use PhpUML\Parser\Tokens\MemberToken;
use PhpUML\Parser\Tokens\NamespaceToken;
use PhpUML\Parser\Tokens\UseToken;

class SourceParser
{
    private PhpFile $file;
    /** @var Stack<PhpClass> */
    private Stack $classes;
    /** @var Stack<PhpMethod> */
    private Stack $methods;
    /** @var Stack<string> */
    private Stack $functions;
    /** @var Stack<PhpInterface> */
    private Stack $interfaces;
    /** @var Stack<int> */
    private Stack $controlStructure;

    public function __construct()
    {
        $this->classes = new Stack();
        $this->methods = new Stack();
        $this->functions = new Stack();
        $this->interfaces = new Stack();
        $this->controlStructure = new Stack();
        $this->file = new PhpFile();
    }

    public function __invoke(string $phpSourceCode): PhpFile
    {
        $this->classes = new Stack();
        $this->methods = new Stack();
        $this->functions = new Stack();
        $this->interfaces = new Stack();
        $this->controlStructure = new Stack();
        $this->file = new PhpFile();
        $tokens = token_get_all($phpSourceCode);
        foreach ($tokens as $id => $token) {
            switch ($token[0]) {
                case T_NAMESPACE:
                    if (strpos($token[1], "$") === false && $this->classes->isEmpty() && $this->interfaces->isEmpty()) {
                        $this->processNamespace($id, $tokens);
                    }
                    break;
                case T_USE:
                    $this->processUseToken($id, $tokens);
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
                case T_INTERFACE:
                    $this->processInterfaceToken($id, $tokens);
                    break;
                case T_IF:
                case T_ELSEIF:
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

    private function processNamespace(int $id, array $tokens): void
    {
        $namespaceToken = new NamespaceToken($id, $tokens);
        $this->file->setNameSpace($namespaceToken->name());
    }

    private function processUseToken(int $id, array $tokens): void
    {
        if ($this->classes->isEmpty() === true) {
            $useToken = new UseToken($id, $tokens);
            $this->file->appendUsedClass(
                [
                    'name' => $useToken->parts()->peek(),
                    'fullName' => $useToken->fullName()
                ]
            );
        }
    }

    private function processClassToken(int $id, array $tokens): void
    {
        if ($this->classes->isEmpty() === true) {
            $phpClassToken = new ClassToken($id, $tokens);
            $this->classes->push(
                new PhpClass(
                    $phpClassToken->className() ?? "anonClass",
                    [],
                    [],
                    $this->file->namespace() ?? "",
                    $phpClassToken->parent(),
                    $phpClassToken->interfaces()
                )
            );
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
                $this->methods->push(new PhpMethod(
                    $methodToken->functionName(),
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
        } elseif ($this->interfaces->isEmpty() === false) {
            $methodToken = new ClassMethod($id, $tokens);
            $this->interfaces->peek()->appendMethods(new PhpMethod(
                $methodToken->functionName(),
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
            $this->functions->push("function not implemented");
        }
    }

    private function processInterfaceToken(int $id, array $tokens): void
    {
        if ($this->interfaces->isEmpty() === true) {
            $interfaceToken = new InterfaceToken($id, $tokens);
            $this->interfaces->push(
                new PhpInterface(
                    $interfaceToken->interfaceName(),
                    [],
                    $this->file->namespace() ?? "",
                    $interfaceToken->getParent()
                )
            );
        }
    }

    private function processControlStructure(int $id, array $tokens): void
    {
        if ($tokens[$id][0] === T_WHILE && $this->controlStructure->isEmpty() === false && $this->controlStructure->peek() === T_DO) {
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

        if ($this->interfaces->isEmpty() === false && $this->methods->isEmpty()) {
            $this->file->appendInterface($this->interfaces->pop());
        }

        if ($this->classes->isEmpty() === false && $this->methods->isEmpty() === false) {
            ($this->classes->peek())->appendMethods(
                $this->methods->pop()
            );
        }
    }
}
