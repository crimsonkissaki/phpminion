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

class MockClasses
{

    public static function getMock_stdClass()
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

    public static function getMock_simple()
    {
        return new SimpleClass();
    }

    public static function getMock_allVisibility()
    {
        return new VisibilityClass();
    }

    public static function getMock_allVisibilityAsModels()
    {
        return VisibilityClassAsPropertyModels::buildFinalForm();
    }

}