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
            array( MockClasses::getMock_allVisibility() ),
            array( MockClasses::getMock_simple() ),
            array( MockClasses::getMock_stdClass() ),
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

    public function test_analyze_returnsProperValues()
    {
        $path = 'PHPMinionTest\Utilities\ClassAnalyzer\\';
        $entity = MockClasses::getMock_fullInheritanceChain();
        $refEntity = new \ReflectionClass($entity);
        $expected = new ClassModel();
        $expected->setName($path.'Mocks\FullInheritanceChainClass');
        $expected->setNameSpace($path.'Mocks');
        $expected->setUses(array(
            $path.'Mocks\SimpleClass',
            $path.'Mocks\SimpleInterface',
            $path.'Mocks\VisibilityClassAsPropertyModels',
        ));
        $expected->setExtends($path.'Mocks\SimpleClass');
        $expected->setImplements(array(
            $path.'Mocks\SimpleInterface',
        ));

        $actual = $this->analyzer->analyze($entity, $refEntity);

        $this->assertEquals($expected, $actual);
    }

}
