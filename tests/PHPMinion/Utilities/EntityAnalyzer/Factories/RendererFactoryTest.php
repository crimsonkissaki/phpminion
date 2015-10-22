<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;

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
        $simpleModelTrue = new ScalarModel();
        $simpleModelTrue->setDataType(gettype(true));
        $simpleModelFalse = new ScalarModel();
        $simpleModelFalse->setDataType(gettype(false));
        $simpleModelNull = new ScalarModel();
        $simpleModelNull->setDataType(gettype(null));
        $simpleModelString = new ScalarModel();
        $simpleModelString->setDataType(gettype('string'));
        $simpleModelInteger = new ScalarModel();
        $simpleModelInteger->setDataType(gettype(10));
        $simpleModelDouble = new ScalarModel();
        $simpleModelDouble->setDataType(gettype(3.14));

        $path = '\PHPMinion\Utilities\EntityAnalyzer\Renderers\\';
        return array(
            array( $path.'ArrayModelRenderer', $arrayModel ),
            array( $path.'ObjectModelRenderer', $objectModel ),
            array( $path.'ScalarModelRenderer', $simpleModelTrue ),
            array( $path.'ScalarModelRenderer', $simpleModelFalse ),
            array( $path.'ScalarModelRenderer', $simpleModelNull ),
            array( $path.'ScalarModelRenderer', $simpleModelString ),
            array( $path.'ScalarModelRenderer', $simpleModelInteger ),
            array( $path.'ScalarModelRenderer', $simpleModelDouble ),
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
