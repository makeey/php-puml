<?php


namespace PhpUML\UML\Formatter;


use PhpUML\UML\Entity\UMLClass;
use PhpUML\UML\Entity\UMLPackage;

class PackageFormatter
{
    public static function format(UMLPackage $package): string
    {
        if ($package->packages() === []) {
            $classes = implode(PHP_EOL, array_map(static function (UMLClass $class): string {
                return ClassFormatter::format($class);
            }, $package->classes()));
            return "package {$package->name()}\n{\n" . $classes  . "\n}\n";
        }
        $packages = implode(array_map(function (UMLPackage $package): string {
            $test = self::format($package);
            return $test;
        }, $package->packages()));
        return <<<EOT
package {$package->name()}
{
{$packages}
}
EOT;

    }
}