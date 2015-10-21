<?php

namespace PHPMinionTest\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Factories\AnalyzerFactory;

/**
 * Class AnalyzerFactoryTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class AnalyzerFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var AnalyzerFactory
     */
    public $factory;

    public function setUp()
    {
        $this->factory = AnalyzerFactory::getInstance();
    }

    public function test_getInstance_returnsAnalyzerFactory()
    {
        $expected = 'PHPMinion\Utilities\EntityAnalyzer\Factories\AnalyzerFactory';
        $actual = AnalyzerFactory::getInstance();

        $this->assertInstanceOf($expected, $actual);
    }

    public function getAnalyzerDataProvider()
    {
        $path = '\PHPMinion\Utilities\EntityAnalyzer\Analyzers\\';
        return array(
            array( $path.'ArrayAnalyzer', ['var1','var2']),
            array( $path.'SimpleAnalyzer', true ),
            array( $path.'SimpleAnalyzer', false ),
            array( $path.'SimpleAnalyzer', null ),
            array( $path.'SimpleAnalyzer', 10 ),
            array( $path.'SimpleAnalyzer', 3.14 ),
            array( $path.'SimpleAnalyzer', 'string var' ),
            array( $path.'ObjectAnalyzer', new \stdClass() ),
        );
    }

    /**
     * @dataProvider getAnalyzerDataProvider
     */
    public function test_getAnalyzer_returnsProperAnalyzerObjectInterface($expected, $value)
    {
        $expected = '\PHPMinion\Utilities\EntityAnalyzer\Analyzers\EntityAnalyzerInterface';
        $actual = AnalyzerFactory::getAnalyzer($value);

        $this->assertInstanceOf($expected, $actual);
    }

    /**
     * @dataProvider getAnalyzerDataProvider
     */
    public function test_getAnalyzer_returnsProperAnalyzerObject($expected, $value)
    {
        $actual = AnalyzerFactory::getAnalyzer($value);

        $this->assertInstanceOf($expected, $actual);
    }

}
