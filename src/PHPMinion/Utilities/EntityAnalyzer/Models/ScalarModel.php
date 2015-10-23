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
class ScalarModel extends DataTypeModel
{

    /**
     * The entity value
     *
     * @var mixed
     */
    private $_value;

    public function getValue()
    {
        return $this->_value;
    }

    public function setValue($value)
    {
        $this->_value = $value;
    }

}