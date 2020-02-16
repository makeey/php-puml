<?php

namespace PhpUML;

class FileWriter implements IWriter
{
    /** @var string*/
    private $path;

    public function __construct(string $path = null)
    {
        $this->path = $path;
    }

    public function setOutput(string $path): IWriter
    {
        $this->path = $path;
        return $this;
    }

    public function write(string $write): void
    {
        if($this->path === null) {
            throw new \InvalidArgumentException("Output file path is null");
        }
        $file = fopen($this->path, "w+");
        fwrite($file, $write);
        fclose($file);
    }
}