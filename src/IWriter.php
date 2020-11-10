<?php declare(strict_types=1);
// @codeCoverageIgnoreStart

namespace PhpUML;

interface IWriter
{
    public function setOutput(string $path): self;
    public function write(string $string): void;
}
