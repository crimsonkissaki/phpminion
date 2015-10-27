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

namespace PHPMinion\Utilities\EntityAnalyzer\Models;

/**
 * Interface DataModelInterface
 *
 * All DataTypeModel entities must implement this
 */
interface DataModelInterface
{

    /**
     * Sets a value for the data model
     *
     * @param mixed $value
     */
    public function setValue($value);

}