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

use PHPMinion\Utilities\EntityAnalyzer\Models\EntityModel;

/**
 * RendererInterface
 *
 * @created     October 19, 2015
 * @version     0.1
 */
interface ModelRendererInterface
{

    /**
     * Renders valid output from an EntityModel
     *
     * @param  EntityModel   $model Model to render
     * @param  int           $level Starting indentation level
     * @return string
     */
    public function renderModel(EntityModel $model, $level = 0);

}