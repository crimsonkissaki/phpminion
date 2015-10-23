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

namespace PHPMinionTest\Utilities\EntityAnalyzer\Workers;

use PHPMinionTest\Utilities\EntityAnalyzer\Mocks\DataTypeModelMocks;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ArrayWorker;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

class ArrayWorkerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ArrayWorker
     */
    public $worker;

    public function setUp()
    {
        $this->worker = new ArrayWorker();
    }

    public function validTypesDataProvider()
    {
        return array(
            array( ['var1', 'var2'] ),
        );
    }

    /**
     * @dataProvider validTypesDataProvider
     */
    public function test_createModel_returnsArrayModel($value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel';
        $actual = $this->worker->createModel($value);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider validTypesDataProvider
     */
    public function test_createModel_returnsCorrectDataTypeInModel($value)
    {
        $expected = 'array';
        $model = $this->worker->createModel($value);
        $actual = $model->getDataType();

        $this->assertEquals($expected, $actual);
    }

    public function invalidTypesDataProvider()
    {
        return array(
            array( true ),
            array( false ),
            array( null ),
            array( 'test string' ),
            array( 10 ),
            array( 3.14 ),
            array( new \stdClass() ),
        );
    }

    /**
     * @dataProvider invalidTypesDataProvider
     * @expectedException \PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException
     */
    public function test_createModel_throwsExceptionForInvalidDataTypes($value)
    {
        $this->worker->createModel($value);
    }

    public function mockedDataProvider()
    {
        return array(
            array( DataTypeModelMocks::getArrayModelMockTwoElements(), DataTypeModelMocks::getMockTwoElementArray() ),
            array( DataTypeModelMocks::getArrayModelMockAssociativeArray(), DataTypeModelMocks::getMockAssociativeArray() ),
            array( DataTypeModelMocks::getArrayModelMockNestedArray(), DataTypeModelMocks::getMockNestedArray() ),
        );
    }

    /**
     * @dataProvider mockedDataProvider
     */
    public function test_createModel_returnsProperDataInModel($expected, $entity)
    {
        $actual = $this->worker->createModel($entity);

        $this->assertEquals($expected, $actual);
    }

}
