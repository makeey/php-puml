<?php // @codeCoverageIgnoreStart


namespace PhpUML\Parser\TransformMiddleware;

use PhpUML\Parser\Entity\PhpFile;

interface IFileTransform
{
    public function transform(PhpFile $phpFile): PhpFile;
}
