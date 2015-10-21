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
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Renderer\ObjectModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Renderer\ArrayModelRenderer;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

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
     * Returns the proper renderer class for the model data type
     *
     * @param  mixed $model
     * @return ModelRendererInterface
     * @throws AnalyzerException
     */
    public static function getModelRenderer(DataTypeModel $model)
    {
        if ($model instanceof ObjectModel) {
            return new ObjectModelRenderer();
        }
        if ($model instanceof ArrayModel) {
            return new ArrayModelRenderer();
        }

        throw new AnalyzerException("No model renderer available in RendererFactory for model type '" . get_class($model) . "'.");
    }

}