<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ScalarAnalyzer;

/**
 * Class ScalarAnalyzerTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class ScalarAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ScalarAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new ScalarAnalyzer();
    }

    public function validAnalyzeDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Models\\';
        return array(
            array( $path.'ScalarModel', true ),
            array( $path.'ScalarModel', false ),
            array( $path.'ScalarModel', null ),
            array( $path.'ScalarModel', 10 ),
            array( $path.'ScalarModel', 3.14 ),
            array( $path.'ScalarModel', 'string var' ),
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
            array( ['var1', 'var2' ] ),
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
