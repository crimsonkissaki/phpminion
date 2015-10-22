<?php

/*
 * This file is part of the PHPMinion package.
 *
 * (c) Evan Johnson <crimsonminion@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$DS = DIRECTORY_SEPARATOR;
$phpminionVendor = dirname(dirname(__FILE__)) . "{$DS}vendor";
$parentVendor = dirname(dirname(dirname(dirname(__FILE__))));
$autoLoad = "{$DS}autoload.php";

$loaderPath = ((is_dir($phpminionVendor)) ? $phpminionVendor : $parentVendor) . $autoLoad;

if (!is_file($loaderPath)) {
    die("Sorry. Can't run unit tests without a valid autoloader file.\n\n");
}

$loader = require $loaderPath;
// define PSR4 namespace to "project root" folder in /tests
$loader->addPsr4('PHPMinionTest\\', dirname(__FILE__) . "{$DS}PHPMinion{$DS}");
