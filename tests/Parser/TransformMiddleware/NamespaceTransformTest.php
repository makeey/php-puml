<?php declare(strict_types=1);

namespace PhpUML\Tests\Parser\TransformMiddleware;

use PhpUML\Parser\Entity\PhpClass;
use PhpUML\Parser\Entity\PhpFile;
use PhpUML\Parser\TransformMiddleware\NamespaceTransform;
use PHPUnit\Framework\TestCase;

class NamespaceTransformTest extends TestCase
{
    public function testTransform(): void
    {
        $class = new PhpClass("Foo", [], [], "Root", "Bar");
        $userClass = [
            'fullName' => "Name\\\\Space\\\\Test\\\\Bar",
            'name' => "Bar"
        ];
        $file = new PhpFile();
        $file->setNameSpace("Name\\\\Space");
        $file->appendUsedClass($userClass);
        $file->appendClass($class);
        $namespaceTransform = new NamespaceTransform();
        $returnedFile = $namespaceTransform->transform($file);

        $this->assertCount(1, $returnedFile->usedClasses());
        $this->assertEquals(
            [
                new PhpClass(
                    "Foo",
                    [],
                    [],
                    "Root",
                    "Name\\\\Space\\\\Test\\\\Bar"
                )
            ],
            $returnedFile->classes()
        );
    }

    public function testTransformParentClassInTheSamePackage(): void
    {
        $namespace = "Name\\\\Space";
        $class = new PhpClass("Foo", [], [], $namespace, "Baz");
        $userClass = [
            'fullName' => "Name\\\\Space\\\\Test\\\\Bar",
            'name' => "Bar"
        ];
        $file = new PhpFile();
        $file->setNameSpace($namespace);
        $file->appendUsedClass($userClass);
        $file->appendClass($class);
        $namespaceTransform = new NamespaceTransform();
        $returnedFile = $namespaceTransform->transform($file);

        $this->assertCount(1, $returnedFile->usedClasses());
        $this->assertEquals(
            [
                new PhpClass(
                    "Foo",
                    [],
                    [],
                    $namespace,
                    "Name\\\\Space\\\\Baz"
                )
            ],
            $returnedFile->classes()
        );
    }

    public function testTransformWithInterfaces(): void
    {
        $class = new PhpClass("Foo", [], [], "Root", "Bar", ['JsonSerializable', "IFoo"]);
        $userClass = [
            [
                'fullName' => "Name\\\\Space\\\\Test\\\\Bar",
                'name' => "Bar"
            ],
            [
                'fullName' => "Name\\\\Space\\\\Test\\\\IFoo",
                'name' => "IFoo",
            ],
            [
                'fullName' => "JsonSerializable",
                'name' => "JsonSerializable",
            ]
        ];
        $file = new PhpFile();
        $file->setNameSpace("Name\\\\Space");
        $file->appendUsedClasses($userClass);
        $file->appendClass($class);
        $namespaceTransform = new NamespaceTransform();
        $returnedFile = $namespaceTransform->transform($file);

        $this->assertCount(3, $returnedFile->usedClasses());
        $this->assertEquals(
            [
                new PhpClass(
                    "Foo",
                    [],
                    [],
                    "Root",
                    "Name\\\\Space\\\\Test\\\\Bar",
                    ['JsonSerializable', "Name\\\\Space\\\\Test\\\\IFoo"]
                )
            ],
            $returnedFile->classes()
        );
    }
}
