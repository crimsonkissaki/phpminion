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
        $obj->prop1 = 'public string value';
        $obj->prop2 = 10;
        $obj->prop3 = 3.14;
        $obj->prop4 = true;
        $obj->prop5 = false;
        $obj->prop6 = null;
        $obj->prop7 = ['public', 'val1', 'val2'];

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