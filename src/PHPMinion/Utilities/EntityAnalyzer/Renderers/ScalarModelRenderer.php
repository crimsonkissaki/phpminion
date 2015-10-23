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
use PHPMinion\Utilities\Core\Common;

/**
 * ScalarModelRenderer
 *
 * Renders an ScalarModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
class ScalarModelRenderer extends DataTypeModelRenderer implements ModelRendererInterface
{

    /**
     * @inheritDoc
     */
    public function renderModel(DataTypeModel $model, $level = 0)
    {
        $output = Common::_getSimpleTypeValue($model->getValue());

        return $output;
    }

}