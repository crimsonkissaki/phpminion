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

namespace PHPMinion\Utilities\EntityAnalyzer;

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Factories\WorkerFactory;
use PHPMinion\Utilities\EntityAnalyzer\Factories\RendererFactory;

/**
 * Class EntityEntityAnalyzer
 *
 * One stop shopping for all your entity analysis needs.
 * "Shop smart. Shop S-Mart."
 *
 * TODO: add options for HTML or CLI rendering of results?
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 22, 2015
 * @version     0.1
 */
class EntityAnalyzer
{

    /**
     * @var  EntityAnalyzer _instance
     */
    private static $_instance;

    private function __construct() {}

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new EntityAnalyzer();
        }

        return self::$_instance;
    }

    /**
     * Analyzes an entity and returns the rendered results
     *
     * Analyze() and Render() have been split off into separate
     * methods to allow for recursive analysis.
     *
     * @param  mixed  $entity
     * @return string
     */
    public static function analyzeAndRender($entity)
    {
        $_this = self::getInstance();
        $model = $_this->analyze($entity);

        return $_this->render($model);
    }

    /**
     * Returns an entity converted to DataTypeModel form
     *
     * @param mixed $entity Target entity for analysis
     * @return DataTypeModel
     */
    public static function analyze($entity)
    {
        $worker = WorkerFactory::getWorker($entity);

        return $worker->createModel($entity);
    }

    /**
     * Converts a DataTypeModel into viewable results
     *
     * @param  DataTypeModel $model
     * @return string
     */
    public static function render(DataTypeModel $model)
    {
        $renderer = RendererFactory::getModelRenderer($model);

        return $renderer->renderModel($model);
    }

}