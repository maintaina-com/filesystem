<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use ValueError;

trait AbsolutePathFromCurrentDirTrait
{
    public static function fromCurrentDir(): AbsolutePathInterface
    {
        return new AbsolutePath(getcwd());
    }
}
