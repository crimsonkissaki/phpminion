<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\SimpleAnalyzer;

/**
 * Class SimpleAnalyzerTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class SimpleAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var SimpleAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new SimpleAnalyzer();
    }

    public function validAnalyzeDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Models\\';
        return array(
            array( $path.'SimpleModel', true ),
            array( $path.'SimpleModel', false ),
            array( $path.'SimpleModel', null ),
            array( $path.'SimpleModel', 10 ),
            array( $path.'SimpleModel', 3.14 ),
            array( $path.'SimpleModel', 'string var' ),
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
     * @expectedException \PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException
     */
    public function test_analyze_throwsExceptionForInvalidDataTypes($value)
    {
        $this->analyzer->analyze($value);
    }

}
