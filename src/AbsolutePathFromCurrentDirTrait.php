<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use RuntimeException;
use ValueError;

trait AbsolutePathFromCurrentDirTrait
{
    public static function fromCurrentDir(): AbsolutePathInterface
    {
        $cwd = getcwd();
        if (!$cwd) {
            throw new RuntimeException('getcwd failed for unknown reasons');
        }
        return new AbsolutePath($cwd);
    }
}
