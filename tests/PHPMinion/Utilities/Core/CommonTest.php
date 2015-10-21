<?php

namespace PHPMinionTest\Utilities\Core;

use PHPMinion\Utilities\Core\Common;
use PHPMinion\Utilities\Core\Config;
use PHPMinion\Utilities\Dbug\Models\TraceModel;

/**
 * Class CommonTest
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 20, 2015
 * @version     0.1
 */
class CommonTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Common
     */
    public $common;

    /**
     * @var Config
     */
    public $config;

    public function setUp()
    {
        $this->common = new Common();
        $this->config = new Config();
    }

    public function test_getRelativeFilePath_returnsProperPath()
    {
        $ds = DIRECTORY_SEPARATOR;
        $pathToFile = $this->config->PROJECT_ROOT_PATH . "PHPMinion{$ds}PHPMinion.php";
        $expected = "PHPMinion{$ds}PHPMinion.php";
        $actual = $this->common->getRelativeFilePath($pathToFile);

        $this->assertEquals($expected, $actual);
    }

    public function test_colorize_returnsCorrectColorCode()
    {
        $testString = 'Test String';
        $testColor = '#00f';
        $expected = "<span style='color: {$testColor}; text-align: left;'>{$testString}</span>";
        $actual = $this->common->colorize($testString, $testColor);

        $this->assertEquals($expected, $actual);
    }

    public function test_getMethodInfo_returnsTraceModel()
    {
        $actual = $this->common->getMethodInfo();

        $this->assertInstanceOf(TraceModel::class, $actual);
    }

    public function simpleTypeProvider()
    {
        return array(
            array( 'BOOLEAN (TRUE)', true ),
            array( 'BOOLEAN (FALSE)', false ),
            array( 'NULL', null),
            array( 'INTEGER (10)', 10 ),
            array( 'DOUBLE (10.01)', 10.01 ),
            array( 'STRING \'(this is a string)\'', 'this is a string' ),
            array( 'ARRAY (2)', ['v1', 'v2'] ),
            array( 'OBJECT (stdClass)', new \stdClass() ),
        );
    }

    /**
     * @dataProvider simpleTypeProvider
     */
    public function test_getSimpleTypeValue($expected, $value)
    {
        $actual = $this->common->getSimpleTypeValue($value);

        $this->assertEquals($expected, $actual);
    }

}
