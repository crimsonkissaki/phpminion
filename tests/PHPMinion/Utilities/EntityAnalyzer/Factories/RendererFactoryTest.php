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
        return array(
            array( $path.'ArrayModelRenderer', new ArrayModel(), ['var1','var2'] ),
            array( $path.'ObjectModelRenderer', new ObjectModel(), new \stdClass() ),
            array( $path.'ScalarModelRenderer', new ScalarModel(), true ),
            array( $path.'ScalarModelRenderer', new ScalarModel(), false ),
            array( $path.'ScalarModelRenderer', new ScalarModel(), null ),
            array( $path.'ScalarModelRenderer', new ScalarModel(), 'test string' ),
            array( $path.'ScalarModelRenderer', new ScalarModel(), 10 ),
            array( $path.'ScalarModelRenderer', new ScalarModel(), 3.14 ),
        );
    }

    /**
     * @dataProvider getModelRendererDataProvider
     */
    public function test_getModelRenderer_returnsProperRendererObjectInterface($rendererClass, $model, $entity)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Renderers\ModelRendererInterface';
        /** @var DataTypeModel $model */
        $model->setDataType(gettype($entity));
        $boom = explode('\\', $rendererClass);
        $class = str_replace('ModelRenderer', '', array_pop($boom));
        $model->setRendererType(strtolower($class));
        $actual = RendererFactory::getModelRenderer($model);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider getModelRendererDataProvider
     */
    public function test_getModelRenderer_returnsProperRendererObject($rendererClass, $model, $entity)
    {
        /** @var DataTypeModel $model */
        $model->setDataType(gettype($entity));
        $boom = explode('\\', $rendererClass);
        $class = str_replace('ModelRenderer', '', array_pop($boom));
        $model->setRendererType(strtolower($class));
        $actual = RendererFactory::getModelRenderer($model);

        $this->assertInstanceOf($rendererClass, $actual);
    }

}
