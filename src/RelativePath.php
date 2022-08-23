<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use ValueError;

/**
 * Represent and manipulate unixoid paths as immutables.
 *
 * @TODO PHP 8.2 baseline: Make readonly
 * @immutable
 */
class RelativePath implements RelativePathInterface
{
    /**
     * TODO PHP 8.1 make readonly
     *
     * @readonly
     *
     * @var string
     */
    private readonly string $path;

    /**
     * Constructor.
     *
     * No default on purpose.
     *
     * use ::fromCurrentDir to get the absolute path to cwd.
     * use '' or './' for the path relative to self
     *
     * @param string $path
     * @throws ValueError
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }


    /**
     * Normalize a path
     *
     * Remove noop . and //
     * Remove ../ together with the preceding level unless it hits the root
     * Remove trailing slashes unless it is the root slash.
     *
     * @return RelativePathInterface
     */
    public function normalize(): RelativePathInterface
    {
        return new RelativePath(Path::normalize($this->path));
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
