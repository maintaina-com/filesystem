<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use Stringable;
use ValueError;

/**
 * Represent and manipulate unixoid paths as immutables.
 *
 * @TODO PHP 8.2 baseline: Make readonly
 * @immutable
 */
class AbsolutePath implements AbsolutePathInterface
{
    use AbsolutePathFromCurrentDirTrait;
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
     * @param string|Stringable $path
     * @throws ValueError
     */
    public function __construct(string|Stringable $path)
    {
        if (!Path::isAbsolutePath($path)) {
            throw new ValueError('Input represents no absolute Path: ' . $path);
        }
        $this->path = $path;
    }

    /**
     * Normalize a path
     *
     * Remove noop . and //
     * Remove ../ together with the preceding level unless it hits the root
     * Remove trailing slashes unless it is the root slash.
     *
     * @return AbsolutePath
     */
    public function normalize(): AbsolutePath
    {
        return new AbsolutePath(Path::normalize($this->path));
    }

    public function addTrailingSlash(): AbsolutePath
    {
        return new AbsolutePath(Path::addTrailingSlash($this->path));
    }

    public function removeTrailingSlash(): AbsolutePath
    {
        return new AbsolutePath(Path::removeTrailingSlash($this->path));
    }

    public function levelUp(int $levels = 1): AbsolutePath
    {
        return new AbsolutePath(Path::levelUp($this->path, $levels));
    }

    public function __toString(): string
    {
        return $this->path;
    }
}
