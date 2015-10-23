<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;

/**
 * Class RendererFactoryTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class RendererFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var RendererFactory
     */
    public $factory;

    public function setUp()
    {
        $this->factory = RendererFactory::getInstance();
    }

    public function test_getInstance_returnsRendererFactory()
    {
        $expected = 'PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory';
        $actual = RendererFactory::getInstance();

        $this->assertInstanceOf($expected, $actual);
    }

    public function getModelRendererDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Renderers\\';
        $arr = ['var1', 'var2'];
        $obj = new \stdClass();
        $str = 'test string';
        $int = 10;
        $float = 3.14;
        return array(
            array( $path.'ArrayModelRenderer', new ArrayModel($arr), $arr ),
            array( $path.'ObjectModelRenderer', new ObjectModel($obj), $obj ),
            array( $path.'ScalarModelRenderer', new ScalarModel(true), true ),
            array( $path.'ScalarModelRenderer', new ScalarModel(false), false ),
            array( $path.'ScalarModelRenderer', new ScalarModel(null), null ),
            array( $path.'ScalarModelRenderer', new ScalarModel($str), $str ),
            array( $path.'ScalarModelRenderer', new ScalarModel($int), $int ),
            array( $path.'ScalarModelRenderer', new ScalarModel($float), $float ),
        );
    }

    /**
     * @dataProvider getModelRendererDataProvider
     */
    public function test_getModelRenderer_returnsProperRendererObjectInterface($rendererClass, $model, $entity)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Renderers\ModelRendererInterface';
        /** @var DataTypeModel $model */
        $actual = RendererFactory::getModelRenderer($model);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider getModelRendererDataProvider
     */
    public function test_getModelRenderer_returnsProperRendererObject($rendererClass, $model, $entity)
    {
        $actual = RendererFactory::getModelRenderer($model);

        $this->assertInstanceOf($rendererClass, $actual, "DataType: '" . gettype($entity) . "': '{$rendererClass}'; Actual: '" . get_class($actual) . "'");
    }

}
