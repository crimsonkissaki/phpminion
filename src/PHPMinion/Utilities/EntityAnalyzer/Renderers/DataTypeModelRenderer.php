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

/**
 * DataTypeModelRenderer
 *
 * Renders an DataTypeModel to something more human-readable
 *
 * @created     October 19, 2015
 * @version     0.1
 */
abstract class DataTypeModelRenderer
{

    protected function indent($level)
    {
        return str_repeat('  ', $level);
    }

}