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

namespace PHPMinionTest\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Factories\WorkerFactory;

/**
 * Class WorkerFactoryTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class WorkerFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var WorkerFactory
     */
    public $factory;

    public function setUp()
    {
        $this->factory = WorkerFactory::getInstance();
    }

    public function test_getInstance_returnsWorkerFactory()
    {
        $expected = 'PHPMinion\Utilities\EntityAnalyzer\Factories\WorkerFactory';
        $actual = WorkerFactory::getInstance();

        $this->assertInstanceOf($expected, $actual);
    }

    public function getAnalyzerDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Workers\\';
        return array(
            array( $path.'ArrayWorker', ['var1','var2']),
            array( $path.'ObjectWorker', new \stdClass() ),
            array( $path.'ScalarWorker', true ),
            array( $path.'ScalarWorker', false ),
            array( $path.'ScalarWorker', null ),
            array( $path.'ScalarWorker', 10 ),
            array( $path.'ScalarWorker', 3.14 ),
            array( $path.'ScalarWorker', 'string var' ),
        );
    }

    /**
     * @dataProvider getAnalyzerDataProvider
     */
    public function test_getAnalyzer_returnsProperWorkerObjectInterface($expected, $value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Workers\DataTypeWorkerInterface';
        $actual = WorkerFactory::getWorker($value);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider getAnalyzerDataProvider
     */
    public function test_getAnalyzer_returnsProperWorkerObject($expected, $value)
    {
        $actual = WorkerFactory::getWorker($value);

        $this->assertInstanceOf($expected, $actual);
    }

}
