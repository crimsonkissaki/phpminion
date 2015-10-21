<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\SimpleModel;

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
        $objectModel = new ObjectModel();
        $objectModel->setDataType(gettype($objectModel));
        $arrayModel = new ArrayModel();
        $arrayModel->setDataType(gettype(['var1', 'var2']));
        $simpleModelTrue = new SimpleModel();
        $simpleModelTrue->setDataType(gettype(true));
        $simpleModelFalse = new SimpleModel();
        $simpleModelFalse->setDataType(gettype(false));
        $simpleModelNull = new SimpleModel();
        $simpleModelNull->setDataType(gettype(null));
        $simpleModelString = new SimpleModel();
        $simpleModelString->setDataType(gettype('string'));
        $simpleModelInteger = new SimpleModel();
        $simpleModelInteger->setDataType(gettype(10));
        $simpleModelDouble = new SimpleModel();
        $simpleModelDouble->setDataType(gettype(3.14));

        $path = '\PHPMinion\Utilities\EntityAnalyzer\Renderers\\';
        return array(
            array( $path.'ArrayModelRenderer', $arrayModel ),
            array( $path.'ObjectModelRenderer', $objectModel ),
            array( $path.'SimpleModelRenderer', $simpleModelTrue ),
            array( $path.'SimpleModelRenderer', $simpleModelFalse ),
            array( $path.'SimpleModelRenderer', $simpleModelNull ),
            array( $path.'SimpleModelRenderer', $simpleModelString ),
            array( $path.'SimpleModelRenderer', $simpleModelInteger ),
            array( $path.'SimpleModelRenderer', $simpleModelDouble ),
        );
    }

    /**
     * @dataProvider getModelRendererDataProvider
     */
    public function test_getModelRenderer_returnsProperRendererObjectInterface($expected, $value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Renderers\ModelRendererInterface';
        $actual = RendererFactory::getModelRenderer($value);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider getModelRendererDataProvider
     */
    public function test_getModelRenderer_returnsProperRendererObject($expected, $value)
    {
        $actual = RendererFactory::getModelRenderer($value);

        $this->assertInstanceOf($expected, $actual);
    }

}
