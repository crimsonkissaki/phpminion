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

use PHPMinionTest\Utilities\EntityAnalyzer\Mocks\ObjectModelMocks;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ObjectWorker;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

class ObjectWorkerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ObjectWorker
     */
    public $worker;

    public function setUp()
    {
        $this->worker = new ObjectWorker();
    }

    public function validTypesDataProvider()
    {
        return array(
            array( ObjectModelMocks::getSimpleObj() ),
        );
    }

    /**
     * @dataProvider validTypesDataProvider
     */
    public function test_createModel_returnsObjectModel($entity)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel';
        $actual = $this->worker->createModel($entity);

        $this->assertInstanceOf($expected, $actual);
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

    public function mockedDataProvider()
    {
        return array(
            array( ObjectModelMocks::getMock_SimpleObj(), ObjectModelMocks::getSimpleObj() ),
        );
    }

    /**
     * @dataProvider mockedDataProvider
     */
    public function test_createModel_returnsProperDataInModel($expected, $entity)
    {
        /*
        echo "\n\nexpected:\n";
        var_dump($expected);
        die();
        */

        $actual = $this->worker->createModel($entity);

        $this->assertEquals($expected, $actual);
    }
}
