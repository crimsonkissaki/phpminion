<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Analyzers\EntityAnalyzer;

/**
 * Class EntityAnalyzerTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class EntityAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var EntityAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = new EntityAnalyzer();
    }

    /**
     * @ignoreTest
     */
    public function test_analyzeAndRender_returnsProperHtml()
    {
        $this->markTestIncomplete('method not fully implemented');

        $testVar = true;
        $expected = '';
        $actual = $this->analyzer->analyzeAndRender($testVar);

        $this->assertEquals($expected, $actual);
    }

    public function analyzeDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Models\\';
        return array(
            array( $path.'ArrayModel', ['var1','var2']),
            array( $path.'ScalarModel', true ),
            array( $path.'ScalarModel', false ),
            array( $path.'ScalarModel', null ),
            array( $path.'ScalarModel', 10 ),
            array( $path.'ScalarModel', 3.14 ),
            array( $path.'ScalarModel', 'string var' ),
            array( $path.'ObjectModel', new \stdClass() ),
        );
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function test_analyze_returnsProperModelType($expected, $value)
    {
        $this->markTestIncomplete('method not fully implemented');

        $actual = $this->analyzer->analyze($value);

        $this->assertInstanceOf($expected, $actual);
    }

}
