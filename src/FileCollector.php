<?php

namespace PhpUML;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class FileCollector implements IFileCollector
{
    public function collect($path, &$result = []): array
    {
        if (is_file($path)) {
            return [$path];
        }
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if ($file->isDir()) {
                self::collect($file, $result);
            }
            $result[] = $file->getPathname();
        }
        return array_filter($result, static function (string $filePath): bool {
            return preg_match('/^.+\.php$/i', $filePath);
        });
    }
}
