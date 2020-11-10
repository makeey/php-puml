<?php declare(strict_types=1);

namespace PhpUML;

class FileWriter implements IWriter
{
    private ?string $path;

    public function setOutput(string $path): IWriter
    {
        $this->path = $path;
        return $this;
    }

    public function write(string $write): void
    {
        if ($this->path === null) {
            throw new \InvalidArgumentException("Output file path is null");
        }
        $file = fopen($this->path, "w+");
        if ($file !== false) {
            fwrite($file, $write);
            fclose($file);
        }
    }
}
