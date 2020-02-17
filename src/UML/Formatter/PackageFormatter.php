<?php

namespace PhpUML\UML\Formatter;

use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLPackage;

class PackageFormatter
{
    public static function format(UMLPackage $package, string $prefix = ""): string
    {
        if ($package->packages() === []) {
            $classes = implode(PHP_EOL, array_map(static function (UMLClass $class): string {
                return ClassFormatter::format($class);
            }, $package->classes()));
            return "package {$prefix}{$package->name()}\n{\n" . $classes . "\n}\n";
        }

        $fullPrefix = $prefix === "" ? $package->name() . "." : $prefix . $package->name() . ".";

        $packages = implode(array_map(function (UMLPackage $package) use ($fullPrefix): string {
            $formattedPackage = self::format($package, $fullPrefix);
            return $formattedPackage;
        }, $package->packages()));

        $classes = implode(PHP_EOL, array_map(static function (UMLClass $class): string {
            return ClassFormatter::format($class);
        }, $package->classes()));

        return <<<EOT
package {$prefix}{$package->name()}
{
{$packages}
{$classes}
}
EOT;

    }
}