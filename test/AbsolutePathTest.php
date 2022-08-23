<?php

declare(strict_types=1);

namespace Horde\Filesystem\Test;

use Horde\Filesystem\AbsolutePath;
use Horde\Filesystem\AbsolutePathInterface;
use Horde\Filesystem\Path;
use Horde\Filesystem\PathFactory;
use Horde\Filesystem\PathInterface;
use Horde\Filesystem\RelativePath;
use Horde\Filesystem\RelativePathInterface;
use PHPUnit\Framework\TestCase;

class AbsolutePathTest extends TestCase
{
    public function testFromCurrentDirIsAbsolute()
    {
        $this->assertInstanceOf(AbsolutePathInterface::class, AbsolutePath::fromCurrentDir());
    }
}
