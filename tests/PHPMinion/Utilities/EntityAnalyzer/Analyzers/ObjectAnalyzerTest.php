<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\ObjectAnalyzer;

/**
 * Class ObjectAnalyzerTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class ObjectAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ObjectAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new ObjectAnalyzer();
    }

    public function validAnalyzeDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Models\\';
        return array(
            // fully qualified class name
            array( $path.'ObjectModel', $path.'ObjectModel' ),
            // object instance
            array( $path.'ObjectModel', new \stdClass() ),
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
            array( true ),
            array( false ),
            array( null ),
            array( 10 ),
            array( 3.14 ),
            array( 'string var' ),
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
