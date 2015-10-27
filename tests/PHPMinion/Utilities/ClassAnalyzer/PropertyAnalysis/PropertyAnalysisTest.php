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

namespace PHPMinionTest\Utilities\PropertyAnalysis;

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\MockClasses;
use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\MockExpected;
use PHPMinion\Utilities\ClassAnalyzer\PropertyAnalysis\PropertyAnalysis;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\PropertyAnalysisException;

class PropertyAnalysisTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PropertyAnalysis
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new PropertyAnalysis();
    }

    public function validArgsDataProvider()
    {
        return array(
            array( MockClasses::stdClass() ),
            array( MockClasses::simple() ),
            array( 'PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel' ),
            array( MockClasses::allVisibility() ),
        );
    }

    /**
     * @dataProvider validArgsDataProvider
     */
    public function test_analyze_returnsArrayOfPropertyModels($entity)
    {
        $object = (is_string($entity)) ? new $entity() : $entity;
        $refEntity = new \ReflectionClass($object);
        $expected = '\PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel';
        $actual = $this->analyzer->analyze($object, $refEntity);

        $this->assertContainsOnlyInstancesOf($expected, $actual);
    }

    public function mockArgsDataProvider()
    {
        return array(
            array( MockClasses::stdClass(), MockExpected::stdClass_propertyModels() ),
            array( MockClasses::allVisibility(), MockExpected::allVisibility_propertyModels() ),
            array( MockClasses::slightlyComplex(), MockExpected::slightlyComplex_propertyModels() ),
            //array( MockClasses::recursive(), '' ),
        );
    }

    /**
     * @dataProvider mockArgsDataProvider
     *
     * TODO: PHP level namespaces need to have an indicator of some sort?
     */
    public function test_analyze_returnsProperValuesForAllProperties($entity, $expected)
    {
        $refEntity = new \ReflectionClass($entity);
        $actual = $this->analyzer->analyze($entity, $refEntity);
        usort($expected, array($this, 'nameCompare'));
        usort($actual, array($this, 'nameCompare'));

        $this->assertEquals($expected, $actual);
    }

    public function nameCompare($a, $b)
    {
        return strcmp($a->getName(), $b->getName());
    }

}
