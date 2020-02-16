<?php

namespace PhpUML\Tests;

use PhpUML\FileCollector;
use PHPUnit\Framework\TestCase;

class FileCollectorTest extends TestCase
{

    public function testCollect(): void
    {
        $array = FileCollector::collect(__DIR__."/data/Collector");
        $this->assertCount(3, $array);
    }

    public function testCanCollectOneFile(): void
    {
        $array = FileCollector::collect(__DIR__."/data/Collector/1.php");
        $this->assertCount(1,$array);
    }
}
