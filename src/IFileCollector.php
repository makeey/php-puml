<?php

namespace PhpUML;

interface IFileCollector
{
    /**
     * @param string $path
     * @param string[] $result
     * @return array
     */
    public function collect(string $path, array &$result = []): array;
}
