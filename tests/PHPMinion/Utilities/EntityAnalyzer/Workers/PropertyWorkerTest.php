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

use PHPMinion\Utilities\EntityAnalyzer\Workers\PropertyWorker;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

class PropertyWorkerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PropertyWorker
     */
    public $worker;

    public function setUp()
    {
        $this->worker = new PropertyWorker();
    }

    public function validTypesDataProvider()
    {
        return array(
            array( new \stdClass() ),
        );
    }

    /**
     * @dataProvider validTypesDataProvider
     */
    public function test_createModel_returnsPropertyModel($value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Models\PropertyModel';
        $actual = $this->worker->createModel($value);

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
    public function _test_createModel_throwsExceptionForInvalidDataTypes($value)
    {
        $this->worker->createModel($value);
    }

    public function mockedDataProvider()
    {
        return array(
            array(),
        );
    }

    /**
     * @dataProvider mockedDataProvider
     */
    public function _test_createModel_returnsProperDataInModel($expected, $entity)
    {

    }
}
