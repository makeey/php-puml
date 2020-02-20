<?php

namespace PhpUML;

interface IFileCollector
{
    public function collect($path, &$array = []): array;
}
