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

use PHPMinion\Utilities\EntityAnalyzer\Workers\ScalarWorker;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

class ScalarWorkerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ScalarWorker
     */
    public $worker;

    public function setUp()
    {
        $this->worker = new ScalarWorker();
    }

    public function scalarTypesDataProvider()
    {
        return array(
            array( true, 'boolean' ),
            array( false, 'boolean' ),
            array( null, 'null' ),
            array( 'test string', 'string' ),
            array( 10, 'integer' ),
            array( 3.14, 'double' ),
        );
    }

    /**
     * @dataProvider scalarTypesDataProvider
     */
    public function test_createModel_returnsScalarModel($entity)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel';
        $actual = $this->worker->createModel($entity);

        $this->assertInstanceOf($expected, $actual);
    }

    public function invalidTypesDataProvider()
    {
        return array(
            array( new \stdClass() ),
            array( ['var1', 'var2'] ),
        );
    }

    /**
     * @dataProvider invalidTypesDataProvider
     * @expectedException \PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException
     */
    public function test_createModel_throwsExceptionForInvalidDataTypes($entity)
    {
        $this->worker->createModel($entity);
    }

    /**
     * @dataProvider scalarTypesDataProvider
     */
    public function test_createModel_returnsProperDataInModel($entity, $expectedDataType)
    {
        $actual = $this->worker->createModel($entity);

        $this->assertEquals($expectedDataType, $actual->getDataType());
        $this->assertEquals('scalar', $actual->getRendererType());
        $this->assertEquals($entity, $actual->getValue());
    }

}
