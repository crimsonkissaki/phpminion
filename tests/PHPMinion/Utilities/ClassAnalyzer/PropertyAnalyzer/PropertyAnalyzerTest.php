<?php
/**
 * PHPMinion
 *
 * A suite of tools to facilitate development and debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */

namespace PHPMinionTest\Utilities\PropertyAnalyzer;

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\MockClasses;
use PHPMinion\Utilities\ClassAnalyzer\PropertyAnalyzer\PropertyAnalyzer;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\PropertyAnalyzerException;

class PropertyAnalyzerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PropertyAnalyzer
     */
    public $analyzer;

    public function setUp()
    {
        $this->analyzer = PropertyAnalyzer::getInstance();
    }

    public function validArgsDataProvider()
    {
        return array(
            array( new \ReflectionObject(MockClasses::getMock_allVisibility()) ),
            array( new \ReflectionObject(MockClasses::getMock_simple()) ),
            array( new \ReflectionObject(MockClasses::getMock_stdClass()) ),
            array( new \ReflectionClass('\PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel') ),
        );
    }

    /**
     * @dataProvider validArgsDataProvider
     */
    public function test_analyze_returnsArrayOfPropertyModels($entity)
    {
        $expected = '\PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel';
        $actual = $this->analyzer->analyze($entity);

        echo "\n\nreturn from propana->analyze:\n\n";
        var_dump($actual);
        die();

        $this->assertContainsOnlyInstancesOf($expected, $actual);
    }

}
