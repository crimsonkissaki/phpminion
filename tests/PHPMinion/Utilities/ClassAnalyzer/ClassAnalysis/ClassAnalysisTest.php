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

namespace PHPMinionTest\Utilities\ClassAnalysis;

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\MockClasses;
use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\MockExpected;
use PHPMinion\Utilities\ClassAnalyzer\ClassAnalysis\ClassAnalysis;
use PHPMinion\Utilities\ClassAnalyzer\Models\ClassModel;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalysisException;

class ClassAnalysisTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ClassAnalysis
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new ClassAnalysis();
    }

    public function validArgsDataProvider()
    {
        return array(
            array( MockClasses::allVisibility() ),
            array( MockClasses::simple() ),
            array( MockClasses::stdClass() ),
            array( '\PHPMinion\Utilities\ClassAnalyzer\Models\ClassModel' ),
        );
    }

    /**
     * @dataProvider validArgsDataProvider
     */
    public function test_analyze_returnsClassModel($entity)
    {
        $object = (is_string($entity)) ? new $entity() : $entity;
        $refObject = new \ReflectionClass($object);
        $expected = '\PHPMinion\Utilities\ClassAnalyzer\Models\ClassModel';
        $actual = $this->analyzer->analyze($object, $refObject);

        $this->assertInstanceOf($expected, $actual);
    }

    public function mocksDataProvider()
    {
        return array(
            array( MockClasses::fullInheritanceChain(), MockExpected::fullInheritanceChain_classModel() ),
            array( MockClasses::stdClass(), MockExpected::stdClass_classModel() ),
            array( MockClasses::allVisibility(), MockExpected::allVisibility_classModel() ),
            array( MockClasses::slightlyComplex(), MockExpected::slightlyComplex_classModel() ),
            array( MockClasses::Complex(), MockExpected::complex_classModel() ),
        );
    }

    /**
     * @dataProvider mocksDataProvider
     */
    public function test_analyze_returnsProperValues($entity, $expected)
    {
        $refEntity = new \ReflectionClass($entity);
        $actual = $this->analyzer->analyze($entity, $refEntity);

        $this->assertEquals($expected, $actual);
    }

}
