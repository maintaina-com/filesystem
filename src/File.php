<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use SplFileInfo;
use SplFileObject;
use Stringable;

/**
 * An OO interface to a file
 *
 *
 * Directories, Files, Device entries etc are nodes
 * This is not a manager though it has some operations.
 * It represents a specific file to reason about, either present or absent
 */
class File implements FileInterface
{
    use GetRelativePathTrait;
    use NodeTrait;
    use SymlinkTrait;
    private SplFileInfo $file;

    public function __construct(AbsolutePathInterface $path)
    {
        $this->path = $path;
    }

    public function delete()
    {
    }
    public function touch()
    {
    }

    public function ensureFileExist(): FileInterface
    {
        return new File(new AbsolutePath('/tmp/egal'));
    }
}
