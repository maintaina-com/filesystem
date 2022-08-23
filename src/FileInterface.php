<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use Stringable;

/**
 * Directories, Files, Device entries etc are nodes
 */
interface FileInterface extends NodeInterface
{
    public function delete();
    public function ensureFileExist(): FileInterface;
    public function touch();
}
