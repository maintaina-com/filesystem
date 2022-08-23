<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use Stringable;

/**
 * Directories, Files, Device entries etc are nodes
 */
class Directory implements DirectoryInterface
{
    use GetRelativePathTrait;
    use DirectoryCreateIfMissingTrait;
    use DirectoryDeleteTrait;
    use NodeTrait;
    use SymlinkTrait;
    public function __construct(AbsolutePathInterface $path)
    {
    }
    public function touch()
    {
    }
}
