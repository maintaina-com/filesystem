<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use RuntimeException;
use ValueError;

trait SymlinkTrait
{
    public function createSymlinkAs(): bool
    {
        return false;
    }
}
