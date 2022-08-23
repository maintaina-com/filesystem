<?php

declare(strict_types=1);

namespace Horde\Filesystem;

use PhpParser\Node\Name\Relative;
use Stringable;

/**
 * The inevitable reusable static helper
 */
class Path
{
    use AbsolutePathFromCurrentDirTrait;
    public static PathFactory $factory;

    public static function fromString(string|Stringable $path): PathInterface
    {
        self::$factory ??= new PathFactory();
        return (self::$factory)($path);
    }

    public static function removeTrailingSlash(string|Stringable $path): string
    {
        if ($path === '/') {
            // noop
            return $path;
        }
        $leading = $path[0] === '/';


        $res = rtrim($path, '/');
        if ($leading & $res == '') {
            return '/';
        }
        return $res;
    }

    /**
     * Idempotent: Ensure there is exactly one trailing slash
     *
     * @param string|Stringable $path
     * @return string
     */
    public static function addTrailingSlash(string|Stringable $path): string
    {
        $res = self::removeTrailingSlash($path);
        if ($res === '/') {
            return $res;
        }
        return $res . '/';
    }

    /**
     * Move up by X levels
     *
     * Implicitly normalizes a path before moving
     * Collision with absolute root / means end.
     * Collision with relative top element means prepend ..
     *
     * @param string|Stringable $path
     * @param integer $levels
     * @return string
     */
    public static function levelUp(string|Stringable $path, $levels = 1): string
    {
        $normal = self::normalize($path);
        $prefix = self::isAbsolutePath($path) ? '/' : '';
        // Catch the empty relative path case and the single element case. Splitting the empty string would lead the wrong way
        if ($normal == '') {
            $elements = [];
        } elseif (!str_contains($normal, '/')) {
            $elements = [$normal];
        } else {
            $elements = explode('/', $normal);
        }
        // Absolute case
        if ($prefix) {
            // drop the empty leading element from the leading /
            array_shift($elements);
            while ($elements && $levels) {
                array_pop($elements);
                $levels--;
            }
            return $prefix . implode('/', $elements);
        }
        // Relative case: If the first element is the dot, pop it for now
        if ($elements && $elements[0] === '.') {
            $prefix = array_shift($elements);
        }
        // Relative case: Consume either all levels or all elements first
        while ($elements && $levels) {
            array_pop($elements);
            $levels--;
        }

        // There are elements left, reassemble
        if ($elements) {
            if ($prefix) {
                array_unshift($elements, $prefix);
            }
            return implode('/', $elements);
        }
        if ($levels) {
            $elements = array_fill(0, $levels, '..');
            if ($prefix) {
                array_unshift($elements, $prefix);
            }
            return implode('/', $elements);
        } else {
            // Dot or empty string
            return $prefix;
        }
    }

    public static function isAbsolutePath(string|Stringable $path): bool
    {
        return $path && $path[0] == '/';
    }

    public static function hasLeadingAnchorDot(string|Stringable $path): bool
    {
        if ($path === '.') {
            return true;
        }
        if (strlen($path) >= 2 && $path[0] == '.' && $path[1] == '/') {
            return true;
        }
        return false;
    }

    /***
     * Remove trailing slashes but not leading slash.
     * Remove multiple slashes and levels containing only '.' unless it is the top anchor
     * Collapse .. levels
     *   - Absolute: Collision with the leading slash is a noop (disappear)
     *   - Relative: One or many ../ levels can precede any others
     */
    public static function normalize(string|Stringable $path): string
    {
        // keep leading / or . as they can be significant
        $prefix = '';
        $keep = [];

        // simplify later checks
        foreach (['', '.', '/'] as $early) {
            if ($path === $early) {
                return $early;
            }
        }

        if ($path[0] === '/') {
            $prefix = '/';
        }
        // Don't bother in this case
        if ($path === './') {
            return '.';
        }
        if ($path[0] === '.' && $path[1] === '/') {
            $prefix = './';
        }

        foreach (explode('/', $path) as $level) {
            if (in_array($level, ['', null], true)) {
                continue;
            }
            if ($level === '.') {
                continue;
            }
            if ($level === '..') {
                $previous = array_pop($keep);
                if ($prefix === '/') {
                    // Absolute: Eliminate previous element and current .., we are done
                    continue;
                }
                // All remaining cases are relative
                if (!$previous) {
                    // Current is the first element, add and be done.
                    $keep[] = $level;
                    continue;
                } elseif ($previous === '..') {
                    // Previous element was .., re-add it
                    $keep[] = $previous;
                } else {
                    // Previous was anything else but existed - lose current and previous
                    continue;
                }
            }
            $keep[] = $level;
        }
        return $prefix .= implode('/', $keep);
    }
}
