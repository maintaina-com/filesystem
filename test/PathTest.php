<?php

declare(strict_types=1);

namespace Horde\Filesystem\Test;

use Horde\Filesystem\Path;
use PHPUnit\Framework\TestCase;

class PathTest extends TestCase
{
    public function testNormalize()
    {
        $data = [
            [
                'input' => '/',
                'expected' => '/',
                'message' => '1',
            ],
            [
                'input' => '//',
                'expected' => '/',
                'message' => '2',
            ],
            [
                'input' => '///',
                'expected' => '/',
                'message' => '3',
            ],
            [
                'input' => '//a//',
                'expected' => '/a',
                'message' => '4',
            ],
            [
                'input' => '//a/',
                'expected' => '/a',
                'message' => '5',
            ],
            [
                'input' => '//a',
                'expected' => '/a',
                'message' => '6',
            ],
            [
                'input' => '//a/././.',
                'expected' => '/a',
                'message' => '7',
            ],
            [
                'input' => '//a/././n',
                'expected' => '/a/n',
                'message' => '8',
            ],
            [
                'input' => '//a/././n/',
                'expected' => '/a/n',
                'message' => '9',
            ],
            [
                'input' => '/../..',
                'expected' => '/',
                'message' => '10',
            ],
            [
                'input' => '..',
                'expected' => '..',
                'message' => '11',
            ],
            [
                'input' => '../..',
                'expected' => '../..',
                'message' => '12 - two levels of relative .. ups stay as they are',
            ],
            [
                'input' => '../../..',
                'expected' => '../../..',
                'message' => '13 - three levels of relative .. ups stay as they are',
            ],
            [
                'input' => '/../../../..',
                'expected' => '/',
                'message' => '14 - Absolute path with only .. levels collapses to root /',
            ],
            [
                'input' => '/../../../../tmp',
                'expected' => '/tmp',
                'message' => '15 - Absolute path loses multiple leading ..',
            ],
            [
                'input' => '../../../../tmp/',
                'expected' => '../../../../tmp',
                'message' => '16 - Relative path does not lose multiple leading ..',
            ],
            [
                'input' => '/var/cache/log/../../tmp/',
                'expected' => '/var/tmp',
                'message' => '17 - Absolute path two level up .. one down tmp',
            ],
            [
                'input' => 'var/cache/log/../../tmp/',
                'expected' => 'var/tmp',
                'message' => '18 - Relative path two level up .. one down tmp',
            ],
            [
                'input' => '.',
                'expected' => '.',
                'message' => '19 - Dot in, Dot out',
            ],
            [
                'input' => './',
                'expected' => '.',
                'message' => '20 - DotSlash in, Dot out',
            ],
            [
                'input' => '.gitignore',
                'expected' => '.gitignore',
                'message' => '20 - A bare filename that happens to start with a dot',
            ],
        ];
        foreach ($data as ['input' => $input, 'expected' => $expected, 'message' => $message]) {
            $this->assertEquals($expected, Path::normalize($input), $message);
        }
    }
    public function testRemoveTrailingSlash()
    {
        $data = [
            [
                'input' => '/',
                'expected' => '/',
                'message' => '1 A slash by itself',
            ],
            [
                'input' => '//',
                'expected' => '/',
                'message' => '2 Ensure the leading slash is kept',
            ],
            [
                'input' => '///',
                'expected' => '/',
                'message' => '3 Ensure the leading slash is kept',
            ],
            [
                'input' => '//a//',
                'expected' => '//a',
                'message' => '4 Double leading slashes are kept if at least one non-slash follows',
            ],
            [
                'input' => '//a/',
                'expected' => '//a',
                'message' => '5 Only tidy until last non-slash',
            ],
            [
                'input' => '//a',
                'expected' => '//a',
                'message' => '6',
            ],
            [
                'input' => '//a/././.',
                'expected' => '//a/././.',
                'message' => '7',
            ],
            [
                'input' => '//a/././n',
                'expected' => '//a/././n',
                'message' => '8',
            ],
       ];
        foreach ($data as ['input' => $input, 'expected' => $expected, 'message' => $message]) {
            $this->assertEquals($expected, Path::removeTrailingSlash($input), $message);
        }
    }
    public function testAddTrailingSlash()
    {
        $data = [
            [
                'input' => '/',
                'expected' => '/',
                'message' => '1 Ensure the leading slash is kept even if it is the whole path',
            ],
            [
                'input' => '//',
                'expected' => '/',
                'message' => '2 Ensure the leading slash is kept, superfluous slashes are lost',
            ],
            [
                'input' => '///',
                'expected' => '/',
                'message' => '3 Ensure the leading slash is kept',
            ],
            [
                'input' => '//a//',
                'expected' => '//a/',
                'message' => '4 Double leading slashes are kept',
            ],
            [
                'input' => '//a',
                'expected' => '//a/',
                'message' => '5 A missing slash is added',
            ],
            [
                'input' => '.',
                'expected' => './',
                'message' => '6 A missing slash is added after . character',
            ],
            [
                'input' => '/.',
                'expected' => '/./',
                'message' => '7 A missing slash is added after . character',
            ],
        ];
        foreach ($data as ['input' => $input, 'expected' => $expected, 'message' => $message]) {
            $this->assertEquals($expected, Path::addTrailingSlash($input), $message);
        }

        // Test idempotence
        $redo = '/var/log';
        $res = [];
        $expected = [
            '/var/log/',
            '/var/log/',
            '/var/log/',
            '/var/log/',
            '/var/log/',
        ];
        for ($i=0; $i < 5; $i++) {
            $redo = Path::addTrailingSlash($redo);
            $res[] = $redo;
        }
        $this->assertEquals($expected, $res, 'Redoing addTrailingSlash changes nothing');
    }

    public function testLevelUp()
    {
        $this->assertEquals('/var/log', Path::levelUp('/var/log/messages'), 'Test going one level up where it is possible');
        $this->assertEquals('/var', Path::levelUp('/var/log/messages', 2), 'Test going two level up where it is possible');
        $this->assertEquals('/', Path::levelUp('/var/log/messages', 3), 'Test going three level up where it is possible');
        $this->assertEquals('/', Path::levelUp('/var/log/messages', 100), 'Test absolute paths cannot go beyond root');
        $this->assertEquals('var/log', Path::levelUp('var/log/messages', 1), 'Test relative up one level');
        $this->assertEquals('./var/log', Path::levelUp('./var/log/messages', 1), 'Test relative up one level with dot');
        $this->assertEquals('./var/log', Path::levelUp('./var/log/messages', 1), 'Test relative up one level with dot');
        $this->assertEquals('./var', Path::levelUp('./var/log/messages', 2), 'Test relative up two level with dot');
        $this->assertEquals('.', Path::levelUp('./var/log/messages', 3), 'Test relative three one level with dot');
        $this->assertEquals('../../..', Path::levelUp('var/log/messages', 6), 'Test relative 3 level too many up');
        $this->assertEquals('..', Path::levelUp('', 1), 'Test relative 1 up');
        $this->assertEquals('../../..', Path::levelUp('', 3), 'Test relative 3 level too many up');
        $this->assertEquals('./..', Path::levelUp('.', 1), 'Test relative 1 up with dot');
        $this->assertEquals('./..', Path::levelUp('./', 1), 'Test relative 1 up with dotslash');
        $this->assertEquals('./../../..', Path::levelUp('./', 3), 'Test relative 3 level up with dotslash');
    }
}
