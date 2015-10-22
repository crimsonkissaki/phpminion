<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ArrayAnalyzer;

/**
 * Class ArrayAnalyzerTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class ArrayAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ArrayAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new ArrayAnalyzer();
    }

    public function validAnalyzeDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Models\\';
        return array(
            array( $path.'ArrayModel', ['var1', 'var2' ] ),
        );
    }

    /**
     * @dataProvider validAnalyzeDataProvider
     */
    public function test_analyze_returnsProperModelType($expected, $value)
    {
        $actual = $this->analyzer->analyze($value);

        $this->assertInstanceOf($expected, $actual);
    }

    public function invalidAnalyzeDataProvider()
    {
        return array(
            array( true ),
            array( false ),
            array( null ),
            array( 10 ),
            array( 3.14 ),
            array( 'string var' ),
            array( new \stdClass() ),
        );
    }

    /**
     * @dataProvider invalidAnalyzeDataProvider
     * @expectedException \PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException
     */
    public function test_analyze_throwsExceptionForInvalidDataTypes($value)
    {
        $this->analyzer->analyze($value);
    }

}
