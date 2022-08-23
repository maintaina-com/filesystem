<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use PhpParser\Node\Name\Relative;
use Stringable;

/**
 * A factory for relative and absolute unixoid paths
 *
 * @TODO PHP 8.2 baseline: Make readonly
 * @immutable
 */
class PathFactory
{
    public function __invoke(string $path): RelativePath|AbsolutePath
    {
        if ($path && $path[0] === '/') {
            return new AbsolutePath($path);
        }
        return new RelativePath($path);
    }
}
