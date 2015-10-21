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

namespace PHPMinion\Utilities\EntityAnalyzer\Renderers;

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;

/**
 * SimpleModelRenderer
 *
 * Renders a SimpleModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class SimpleModelRenderer implements ModelRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderModel(DataTypeModel $model, $level = 0)
    {
        $output = "Non-functional SimpleModelRenderer->renderModel()";

        return $output;
    }

    private function indent($level)
    {
        return str_repeat('  ', $level);
    }

}