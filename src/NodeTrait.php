<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use RuntimeException;
use ValueError;

trait NodeTrait
{
    protected AbsolutePathInterface $path;

    public function isExecutable(): bool
    {
        return false;
    }
    public function isReadable(): bool
    {
        return false;
    }
    public function isWriteable(): bool
    {
        return false;
    }
    public function isLink(): bool
    {
        return false;
    }
    public function exists(): bool
    {
        return false;
    }
    public function getAbsolutePath(): AbsolutePath
    {
        return $this->path;
    }
}
