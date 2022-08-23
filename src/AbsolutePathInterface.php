<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use Stringable;

/**
 * Represents either an absolute or a relative Path
 *
 * @TODO PHP 8.2 baseline: Make readonly
 * @immutable
 */
interface AbsolutePathInterface extends PathInterface
{
    public static function fromCurrentDir(): AbsolutePathInterface;
    public function normalize(): AbsolutePathInterface;
}
