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
 * Class ScalarModel
 *
 * Holds boolean data type information
 *
 * @created     October 22, 2015
 * @version     0.1
 */
class ScalarModel extends DataTypeModel implements DataModelInterface
{

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function __construct($value)
    {
        parent::__construct($value);
        $this->setValue($value);
    }

}