<?php
declare(strict_types=1);

namespace Horde\Filesystem;
use Stringable;

/**
 * Directories, Files, Device entries etc are nodes
 */
class File implements FileInterface
{
    public function __construct(AbsolutePathInterface $path)
    {
        
    }

}