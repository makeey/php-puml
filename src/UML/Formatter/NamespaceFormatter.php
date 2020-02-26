<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLNamespace;

class NamespaceFormatter
{
    /** @var InterfaceFormatter */
    private $interfaceFormatter;
    /** @var ClassFormatter **/
    private $classFormatter;

    public function __construct(InterfaceFormatter $intrfaceFormatter, ClassFormatter $classFormatter)
    {
        $this->interfaceFormatter = $intrfaceFormatter;
        $this->classFormatter = $classFormatter;
    }

    public function format(UMLNamespace $package, string $prefix = ""): string
    {
        if ($package->namespaces() === []) {
            $classes = implode(PHP_EOL, array_map(function (UMLClass $class): string {
                return $this->classFormatter->format($class);
            }, $package->classes()));
            $interfaces = implode(PHP_EOL, array_map(function (UMLInterface $interface): string {
                return $this->interfaceFormatter->format($interface);
            }, $package->interfaces()));
            return "\nnamespace {$prefix}{$package->name()} {\n" . $classes . "\n{$interfaces}\n}\n";
        }

        $fullPrefix = $prefix === "" ? $package->name() . "." : $prefix . $package->name() . ".";

        $packages = implode(array_map(function (UMLNamespace $package) use ($fullPrefix): string {
            $formattedPackage = $this->format($package, $fullPrefix);
            return $formattedPackage;
        }, $package->namespaces()));

        $classes = implode(PHP_EOL, array_map(function (UMLClass $class): string {
            return $this->classFormatter->format($class);
        }, $package->classes()));

        $interfaces = implode(PHP_EOL, array_map(function (UMLInterface $interface): string {
            return $this->interfaceFormatter->format($interface);
        }, $package->interfaces()));

        return <<<EOT

namespace {$prefix}{$package->name()} {
{$packages}
{$classes}
{$interfaces}
}
EOT;
    }
}
