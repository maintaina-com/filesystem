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
interface PathInterface extends Stringable
{
    public function normalize(): PathInterface;
}
