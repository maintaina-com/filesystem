<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use DirectoryIterator;
use Stringable;

/**
 * A unixoid filesystem directory
 *
 * Directories, Files, Device entries etc are nodes
 * Implement behaviour similar to FilesystemIterator, possibly wrapping it.
 *
 *
 */
interface DirectoryInterface extends NodeInterface
{
    public function createIfMissing();
    public function deleteIfEmpty();
    public function deleteRecursively();
    public function createSubDir(PathInterface $dir): DirectoryInterface;
}
