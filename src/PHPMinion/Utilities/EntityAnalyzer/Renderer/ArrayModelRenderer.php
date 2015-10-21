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

namespace PHPMinion\Utilities\EntityAnalyzer\Renderer;

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;

/**
 * ArrayModelTranslator
 *
 * Translates an ArrayModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class ArrayModelRenderer implements ModelRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderModel(DataTypeModel $model, $level = 0)
    {
        $output = "Non-functional ArrayModelRenderer->renderModel()";

        return $output;
    }

    private function indent($level)
    {
        return str_repeat('  ', $level);
    }

}