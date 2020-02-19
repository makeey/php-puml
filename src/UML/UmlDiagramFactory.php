<?php

namespace PhpUML\UML;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpInterface;
use PhpUML\Parser\Entity\PhpMethod;
use PhpUML\Parser\Entity\PhpMethodParameter;
use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLMethod;
use PhpUML\UML\Entity\UMLMethodParameter;
use PhpUML\UML\Entity\UMLPackage;
use PhpUML\UML\Entity\UMLProperty;

class UmlDiagramFactory implements IUMLDiagramFactory
{
    public function buildDiagram(PhpFile $file): UMLDiagram
    {
        $nameSpace = $file->namespace();
        $nameSpaceParts = explode("\\\\", $nameSpace);
        return new UMLDiagram(
            [
                $this->buildNestedPackages($nameSpaceParts, $file->classes(), $file->interfaces())
            ]
        );
    }

    private function buildNestedPackages(array $packages, array $classes, array $intefraces, $i = 0)
    {
        if ($i === count($packages) - 1) {
            return new UMLPackage($packages[$i], [], array_map(function (PhpClass $class): UMLClass {
                return $this->buildClassFromPhpClass($class);
            }, $classes),
                array_map(function (PhpInterface $interface): UMLInterface {
                    return $this->buildInterfaceFromPhpInterface($interface);
                }, $intefraces)
            );
        }
        return new UMLPackage(
            $packages[$i],
            [$this->buildNestedPackages($packages, $classes, $intefraces, $i + 1)],
            [],
            []
        );
    }

    private function buildClassFromPhpClass(PhpClass $class): UMLClass
    {
        return new UMLClass(
            $class->name(),
            array_map(static function (PhpMethod $method): UMLMethod {
                return new UMLMethod($method->name(), $method->accessModifier(), ...array_map(
                    static function (PhpMethodParameter $parameter): UMLMethodParameter {
                        return new UMLMethodParameter($parameter->name(), $parameter->type());
                    }, $method->parameters()));
            },
                $class->methods()),
            array_map(static function (PhpClassMember $method): UMLProperty {
                return new UMLProperty($method->name(), $method->accessModifier(), $method->type());
            },
                $class->properties()
            ),
            $class->parent(),
            $class->implements()
        );
    }

    private function buildInterfaceFromPhpInterface(PhpInterface $interface): UMLInterface
    {
        return new UMLInterface(
            $interface->interfaceName(),
            array_map(static function (PhpMethod $method): UMLMethod {
                return new UMLMethod($method->name(), $method->accessModifier(), ...array_map(
                    static function (PhpMethodParameter $parameter): UMLMethodParameter {
                        return new UMLMethodParameter($parameter->name(), $parameter->type());
                    }, $method->parameters()));
            }, $interface->methods())
        );
    }
}