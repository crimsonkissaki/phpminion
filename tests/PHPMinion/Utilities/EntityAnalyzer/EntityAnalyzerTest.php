<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer;

use PHPMinion\Utilities\EntityAnalyzer\EntityAnalyzer;

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
        $this->analyzer = EntityAnalyzer::getInstance();
    }

    public function analyzeDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Models\\';
        return array(
            array( $path.'ArrayModel', ['var1','var2']),
            array( $path.'ObjectModel', new \stdClass() ),
            array( $path.'ScalarModel', true ),
            array( $path.'ScalarModel', false ),
            array( $path.'ScalarModel', null ),
            array( $path.'ScalarModel', 10 ),
            array( $path.'ScalarModel', 3.14 ),
            array( $path.'ScalarModel', 'string var' ),
            /**  array( $path.'ResourceModel', <a resource> ), **/
        );
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function test_analyze_returnsProperModelType($expected, $entity)
    {
        $actual = $this->analyzer->analyze($entity);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function test_render_returnsString($modelType, $entity)
    {
        $model = $this->analyzer->analyze($entity);
        $renderResult = $this->analyzer->render($model);

        $this->assertTrue(is_string($renderResult));
    }

    /**
     * @dataProvider analyzeDataProvider
     */
    public function _test_analyzeAndRender_returnsString($modelClass, $entity)
    {
        // not working: analyzer broken?
        $actual = $this->analyzer->analyzeAndRender($entity);

        $this->assertTrue(is_string($actual));
    }

}
