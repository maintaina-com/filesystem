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

class PathFactoryTest extends TestCase
{
    private PathFactory $factory;
    public function setUp(): void
    {
        $this->factory = new PathFactory();
    }
    public function testTypeOfPath()
    {
        $this->assertInstanceOf(AbsolutePath::class, ($this->factory)('/'));
        $this->assertInstanceOf(AbsolutePath::class, ($this->factory)('/..'));
        $this->assertInstanceOf(AbsolutePath::class, ($this->factory)('/var/log'));
        $this->assertInstanceOf(RelativePath::class, ($this->factory)('..'));
        $this->assertInstanceOf(RelativePath::class, ($this->factory)('../..'));
        $this->assertInstanceOf(RelativePath::class, ($this->factory)(''));
    }

    public function testInterfaceHierarchy()
    {
        $this->assertInstanceOf(AbsolutePath::class, ($this->factory)('/'));
        $this->assertInstanceOf(AbsolutePathInterface::class, ($this->factory)('/'));
        $this->assertInstanceOf(PathInterface::class, ($this->factory)('/'));
        $this->assertInstanceOf(PathInterface::class, ($this->factory)('..'));
        $this->assertInstanceOf(RelativePath::class, ($this->factory)('..'));
        $this->assertInstanceOf(RelativePathInterface::class, ($this->factory)('..'));
    }
}
