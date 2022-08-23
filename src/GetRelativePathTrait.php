<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use RuntimeException;
use ValueError;

trait GetRelativePathTrait
{
    public function getPathRelativeTo(AbsolutePath $path): RelativePath
    {
        return new RelativePath('');
    }
}
