<?php

/*
 * This file is part of the PHPMinion package.
 *
 * (c) Evan Johnson <crimsonminion@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

// path to Composer autoload file
$loader = require dirname(dirname(__FILE__)) . '/vendor/autoload.php';

// define PSR4 namespace to "project root" folder in /tests
$loader->addPsr4('PHPMinionTest\\', dirname(__FILE__) . '/PHPMinion/');
