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
            array( MockClasses::getMock_allVisibility() ),
            array( new \ReflectionObject(MockClasses::getMock_simple()) ),
            array( new \ReflectionObject(MockClasses::getMock_stdClass()) ),
            array( new \ReflectionClass('\PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel') ),
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

    public function test_analyze_returnsProperValuesForAllProperties()
    {
        $expected = MockClasses::getMock_allVisibilityAsModels();
        $entity = MockClasses::getMock_allVisibility();
        $refEntity = new \ReflectionClass($entity);
        $actual = $this->analyzer->analyze($entity, $refEntity);

        // may have to eventually manually re-order the arrays for this to work
        $this->assertEquals($expected, $actual);
    }

}
