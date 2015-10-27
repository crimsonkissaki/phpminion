<?php
/**
 * PHPMinion
 *
 * A suite of tools to facilitate development and debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes;

/**
 * Class RecursiveClass
 *
 * Similar to some situations with Doctrine entities,
 * you can have a "parent" class with one-to-one|many
 * relationships with children classes, who have a
 * one-to-one relationship back (recursive) which throws
 * var_dump/print_r for a loop causing out of RAM errors.
 */
class RecursiveClass
{

    private $string = 'property1 value';

    private $integer = 10;

    private $double = 3.14;

    private $true = true;

    private $false = false;

    private $null;

    private $array = ['val1', 'val2'];

    private $subRecursiveClass;

    public function __construct()
    {
        $this->subRecursiveClass = new SubRecursiveClass();
    }

}