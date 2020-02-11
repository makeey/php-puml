<?php


use PhpUML\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    public function testCan()
    {
        $umlClass = Parser::parse(__DIR__. '/data/Foo.php');
        $this->assertEquals($umlClass->jsonSerialize()['className'], 'Foo');
    }

    public function testCanGetParameters()
    {
        $umlClass = Parser::parse(__DIR__. '/data/Test1.php');
        $this->assertEquals($umlClass->jsonSerialize()['className'], 'Test1');
    }
}