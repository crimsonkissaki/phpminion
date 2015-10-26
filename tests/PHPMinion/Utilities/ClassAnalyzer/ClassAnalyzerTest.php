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

namespace PHPMinionTest\Utilities\ClassAnalyzer;

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\MockClasses;
use PHPMinion\Utilities\ClassAnalyzer\ClassAnalyzer;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalyzerException;

class ClassAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ClassAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new ClassAnalyzer();
    }

    public function invalidArgsDataProvider()
    {
        return [
            ['invalid string'],
            [10],
            [3.14],
            [true],
            [false],
            [null],
            ['\Looks\Right\But\Not\Quite'],
            [['var1','var2']],
        ];
    }

    /**
     * @dataProvider invalidArgsDataProvider
     * @expectedException \PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalyzerException
     */
    public function test_analyze_throwsExceptionForInvalidArgument($arg)
    {
        $this->analyzer->analyze($arg);
    }

    public function validArgsDataProvider()
    {
        return [
            [ MockClasses::stdClass() ],
            [ '\PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel' ],
        ];
    }

    /**
     * @dataProvider validArgsDataProvider
     */
    public function test_analyze_returnsValidClassAnalyzerForValidArgs($entity)
    {
        $expected = '\PHPMinion\Utilities\ClassAnalyzer\ClassAnalyzer';
        $actual = $this->analyzer->analyze($entity);

        $this->assertInstanceOf($expected, $actual);
    }

}
