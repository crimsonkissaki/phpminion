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
        $this->analyzer = new EntityAnalyzer();
    }

    /**
     * @ignoreTest
     */
    public function _test_analyzeAndRender_returnsProperHtml()
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
        $model->setDataType(gettype($entity));
        $class = str_replace('Model', '', array_pop(explode('\\', $modelType)));
        $model->setRendererType(strtolower($class));
        $renderResult = $this->analyzer->render($model);

        $this->assertTrue(is_string($renderResult));
    }

}
