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
 * Class SubRecursiveClass
 *
 * This acts as a 'one-to-one|many' child class which
 * points back to the parent class.
 */
class SubRecursiveClass
{

    private $string = 'sub recursive class';

    private $integer = 1;

    private $double = .314;

    private $true = true;

    private $false = false;

    private $null;

    private $array = ['sub_val1', 'sub_val2'];

    private $recursiveClass;

    public function __construct()
    {
        $this->recursiveClass = new RecursiveClass();
    }

}