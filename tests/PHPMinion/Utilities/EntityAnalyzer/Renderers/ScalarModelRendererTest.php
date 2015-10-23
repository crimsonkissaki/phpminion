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

namespace PHPMinionTest\Utilities\EntityAnalyzer\Renderers;

use PHPMinion\Utilities\EntityAnalyzer\Workers\ScalarWorker;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ScalarModelRenderer;

class ScalarModelRendererTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ScalarModelRenderer
     */
    public $renderer;

    /**
     * @var ScalarWorker
     */
    public $worker;

    public function setUp()
    {
        $this->renderer = new ScalarModelRenderer();
        $this->worker = new ScalarWorker();
    }

    public function scalarTypesDataProvider()
    {
        return array(
            array( 'test string', "STRING ('test string')" ),
            array( true, 'BOOLEAN (TRUE)' ),
            array( false, 'BOOLEAN (FALSE)' ),
            array( null, 'NULL' ),
            array( 10, 'INTEGER (10)' ),
            array( 3.14, 'DOUBLE (3.14)' ),
        );
    }

    public function getModel($entity)
    {
        return $this->worker->createModel($entity);
    }

    /**
     * @dataProvider scalarTypesDataProvider
     */
    public function test_renderModel_returnsProperText($entity, $expected)
    {
        $model = $this->getModel($entity);
        $actual = $this->renderer->renderModel($model);

        $this->assertEquals($expected, $actual);
    }

}
