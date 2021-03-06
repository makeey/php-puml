<?php declare(strict_types=1);

namespace PhpUML\Tests;

use PhpUML\FileCollector;
use PHPUnit\Framework\TestCase;

class FileCollectorTest extends TestCase
{
    public function testCollect(): void
    {
        $fileCollection = new FileCollector();
        $array = $fileCollection->collect(__DIR__."/data/Collector");
        $this->assertCount(3, $array);
    }

    public function testCanCollectOneFile(): void
    {
        $fileCollection = new FileCollector();
        $array = $fileCollection->collect(__DIR__."/data/Collector/1.php");
        $this->assertCount(1, $array);
    }
}
