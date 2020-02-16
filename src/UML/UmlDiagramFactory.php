<?php

namespace PhpUML\UML;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpClassMember;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\Entity\PhpMethod;
use PhpUML\Parser\Entity\PhpMethodParameter;
use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLDiagram;
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
                $this->buildNestedPackages($nameSpaceParts, $file->classes())
            ]
        );
    }

    private function buildNestedPackages(array $packages, array $classes, $i = 0)
    {
        if ($i === count($packages) - 1) {
            return new UMLPackage($packages[$i], [], array_map(function (PhpClass $class): UMLClass {
                    return $this->buildClassFromPhpClass($class);
                }, $classes
                )
            );
        }
        return new UMLPackage($packages[$i], [$this->buildNestedPackages($packages, $classes, $i + 1)], []);
    }

    private function buildClassFromPhpClass(PhpClass $class): UMLClass
    {
        return new UMLClass(
            $class->name(),
            array_map(static function (PhpMethod $method): UMLMethod {
                return new UMLMethod($method->name(), ...array_map(
                    static function (PhpMethodParameter $parameter): UMLMethodParameter {
                        return new UMLMethodParameter($parameter->name(), $parameter->type());
                    }, $method->parameters()));
            },
                $class->methods()),
            array_map(static function (PhpClassMember $method): UMLProperty {
                return new UMLProperty($method->name(), $method->accessModifier(), $method->type());
            },
                $class->properties()
            ));
    }
}