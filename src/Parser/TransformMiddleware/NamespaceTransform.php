<?php

namespace PhpUML\Parser\TransformMiddleware;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpFile;

class NamespaceTransform implements IFileTransform
{

    public function transform(PhpFile $phpFile): PhpFile
    {
        $newFile = new PhpFile();
        return $newFile->setNameSpace($phpFile->namespace())
            ->appendUsedClasses($phpFile->usedClasses())
            ->appendClasses(...array_map(function (PhpClass $class) use ($phpFile) : PhpClass {
                return new PhpClass(
                    $class->name(),
                    $class->properties(),
                    $class->methods(),
                    $class->namespace(),
                    $this->modifyEntityName($class->parent(), $phpFile),
                    array_map(function ($interface) use ($phpFile): string {
                        return $this->modifyEntityName($interface, $phpFile);
                    }, $class->implements())
                );
            }, $phpFile->classes()))
            ->appendInterfaces(...$phpFile->interfaces());

    }

    private function modifyEntityName(?string $name, PhpFile $phpFile): ?string
    {
        if ($name !== null) {
            foreach ($phpFile->usedClasses() as $usedClass) {
                if ($name === $usedClass['name']) {
                    return $usedClass['fullName'];
                }
            }
            return $phpFile->namespace() . "\\\\" . $name;
        }
        return $name;
    }
}