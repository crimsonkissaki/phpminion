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

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks;

/**
 * Class MockClasses
 *
 * Mock classes for testing analysis
 */
class MockClasses
{

    public static function stdClass()
    {
        $obj = new \stdClass();
        $obj->public_string = 'public string value';
        $obj->public_integer = 10;
        $obj->public_double = 3.14;
        $obj->public_true = true;
        $obj->public_false = false;
        $obj->public_null = null;
        $obj->public_array = ['public', 'val1', 'val2'];

        return $obj;
    }

    public static function simple()
    {
        return new Classes\SimpleClass();
    }

    public static function allVisibility()
    {
        return new Classes\VisibilityClass();
    }

    public static function fullInheritanceChain()
    {
        return new Classes\FullInheritanceChainClass();
    }

}