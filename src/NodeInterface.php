<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use Stringable;

/**
 * Directories, Files, Device entries etc are nodes
 */
interface NodeInterface
{
    public function getAbsolutePath(): AbsolutePath;
    public function getPathRelativeTo(AbsolutePath $path): RelativePath;
    public function exists(): bool;
    public function isReadable(): bool;
    public function isWriteable(): bool;
    public function isExecutable(): bool;
    public function isLink(): bool;
    public function touch();
    public function createSymlinkAs(PathInterface $path);
}
