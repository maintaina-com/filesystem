<?php

declare(strict_types=1);

if (!class_exists('Horde_Test_AllTests')) {
    require_once 'Horde/Test/AllTests.php';
}
Horde\Test\AllTests::init(__FILE__)->run();
