<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLInterface;
use PhpUML\UML\Entity\UMLNamespace;

class NamespaceFormatter
{
    public static function format(UMLNamespace $package, string $prefix = ""): string
    {
        if ($package->namespaces() === []) {
            $classes = implode(PHP_EOL, array_map(static function (UMLClass $class): string {
                return ClassFormatter::format($class);
            }, $package->classes()));
            $interfaces = implode(PHP_EOL, array_map(static function (UMLInterface $interface): string {
                return InterfaceFormatter::format($interface);
            }, $package->interfaces()));
            return "\nnamespace {$prefix}{$package->name()} {\n" . $classes . "\n{$interfaces}\n}\n";
        }

        $fullPrefix = $prefix === "" ? $package->name() . "." : $prefix . $package->name() . ".";

        $packages = implode(array_map(function (UMLNamespace $package) use ($fullPrefix): string {
            $formattedPackage = self::format($package, $fullPrefix);
            return $formattedPackage;
        }, $package->namespaces()));

        $classes = implode(PHP_EOL, array_map(static function (UMLClass $class): string {
            return ClassFormatter::format($class);
        }, $package->classes()));

        $interfaces = implode(PHP_EOL, array_map(static function (UMLInterface $interface): string {
            return InterfaceFormatter::format($interface);
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