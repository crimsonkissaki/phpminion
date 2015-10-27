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
 * Class MockExpected
 *
 * Access to 'Expected' ClassModel versions of mocked classes
 */
class MockExpected
{

    /**
     * stdClass as ClassModel
     *
     * @return array
     */
    public static function stdClass_classModel()
    {
        return Expected\Classes\StdClass::getClassModel();
    }

    /**
     * stdClass as PropertyModel[]
     *
     * @return array
     */
    public static function stdClass_propertyModels()
    {
        return Expected\Properties\StdClass::getPropertyModels();
    }

    /**
     * VisibilityClass as ClassModel
     *
     * @return array
     */
    public static function allVisibility_classModel()
    {
        return Expected\Classes\VisibilityClass::getClassModel();
    }

    /**
     * VisibilityClass as PropertyModel[]
     *
     * @return array
     */
    public static function allVisibility_propertyModels()
    {
        return Expected\Properties\VisibilityClass::getPropertyModels();
    }

    /**
     * What should be the end results of analyzing the VisibilityClass mock
     *
     * @return array
     */
    public static function fullInheritanceChain_classModel()
    {
        return Expected\Classes\FullInheritanceChainClass::getClassModel();
    }

    /**
     * Intended result of analyzing the SlightlyComplexClass mock
     *
     * @return array
     */
    public static function slightlyComplex_classModel()
    {
        return Expected\Classes\SlightlyComplexClass::getClassModel();
    }

    /**
     * Intended result of analyzing the SlightlyComplexClass mock properties
     *
     * @return array
     */
    public static function slightlyComplex_propertyModels()
    {
        return Expected\Properties\SlightlyComplexClass::getPropertyModels();
    }

    /**
     * Intended result of analyzing the ComplexClass mock
     *
     * @return array
     */
    public static function complex_classModel()
    {
        return Expected\Classes\ComplexClass::getClassModel();
    }

    /**
     * Intended result of analyzing the ComplexClass mock properties
     *
     * @return array
     */
    public static function complex_propertyModels()
    {
        return Expected\Properties\ComplexClass::getPropertyModels();
    }

}