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
            array( true ),
            array( false ),
            array( null ),
            array( 'test string' ),
            array( 10 ),
            array( 3.14 ),
        );
    }

    /**
     * @dataProvider scalarTypesDataProvider
     */
    public function test_workEntity_returnsScalarModel($value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Workers\ScalarModel';
        $actual = $this->worker->workEntity($value);

        $this->assertInstanceOf($expected, $actual);
    }

}
