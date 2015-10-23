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

    public function scalarTypesDataProvider()
    {
        return array(
            array( new \stdClass() ),
        );
    }

    /**
     * @dataProvider scalarTypesDataProvider
     */
    public function test_createModel_returnsObjectModel($value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel';
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
    public function test_createModel_throwsExceptionForInvalidDataTypes($value)
    {
        $this->worker->createModel($value);
    }

}
