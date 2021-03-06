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

namespace PHPMinion\Utilities\EntityAnalyzer\Factories;

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ObjectModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ArrayModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ScalarModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Renderers\ModelRendererInterface;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * RendererFactory
 *
 * Returns the proper renderer class for an entity type
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class RendererFactory
{

    /**
     * @var RendererFactory
     */
    public static $_instance;

    /**
     * Array of renderers
     *
     * @var array
     */
    private $_renderers = [];

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new RendererFactory();
        }

        return self::$_instance;
    }

    /**
     * Returns the proper renderer class for the model data type
     *
     * @param  mixed $model
     * @return ModelRendererInterface
     * @throws EntityAnalyzerException
     */
    public static function getModelRenderer(DataTypeModel $model)
    {
        $_this = self::getInstance();
        $dataType = $model->getDataType();

        if (isset($_this->_renderers[$dataType])) {
            return $_this->_renderers[$dataType];
        }

        $renderer = false;
        switch ($dataType) {
            case 'object':
                $renderer = new ObjectModelRenderer();
                break;
            case 'array':
                $renderer = new ArrayModelRenderer();
                break;
            case 'boolean':
            case 'float':
            case 'double':
            case 'integer':
            case 'null':
            case 'string':
                $renderer = new ScalarModelRenderer();
                break;
        }

        if (!$renderer) {
            throw new EntityAnalyzerException("No model renderer available in RendererFactory for model type '{$dataType}'.");
        }

        $_this->_renderers[$dataType] = $renderer;

        return $_this->_renderers[$dataType];
    }

}