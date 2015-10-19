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

namespace PHPMinion\Utilities\ObjectAnalyzer\Renderer;

use PHPMinion\Utilities\ObjectAnalyzer\Models\ObjectModel;

/**
 * ObjectModelTranslatorInterface
 *
 * @created     October 19, 2015
 * @version     0.1
 */
interface ObjectModelRendererInterface
{

    /**
     * Renders valid output from an ObjectModel
     *
     * @param  ObjectModel $model
     * @return string
     */
    public function renderObjectModel(ObjectModel $model);

}