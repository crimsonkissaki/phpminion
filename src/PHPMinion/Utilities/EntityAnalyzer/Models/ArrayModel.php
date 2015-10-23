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

use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * Class ArrayModel
 *
 * Model to hold array data
 *
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayModel extends DataTypeModel
{

    /**
     * Array of keys => data models
     *
     * @var array
     */
    private $_elements = [];

    /**
     * @return array
     */
    public function getElements()
    {
        return $this->_elements;
    }

    /**
     * @param array $elements
     */
    public function setElements(array $elements)
    {
        $this->_elements = $elements;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @throws EntityAnalyzerException
     */
    public function addElement($key, $value)
    {
        $this->_elements[$key] = $value;
    }

    public function getElement($key)
    {
        if (isset($this->_elements[$key])) {
            return $this->_elements[$key];
        }

        throw new EntityAnalyzerException("No array element exists for key '{$key}'.");
    }

}