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
 * Class ObjectModel
 *
 * Model to hold object data
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectModel extends DataTypeModel
{

    /**
     * Class represented by the ObjectModel
     *
     * @var string
     */
    private $_className;

    /**
     * Class properties
     *
     * @var array
     */
    private $_properties = [];

    //public $methods = [];

    public function getClassName()
    {
        return $this->_className;
    }

    /**
     * @param string $visibility
     * @param string $name
     * @param DataTypeModel $value
     */
    public function addProperty($visibility, $name, DataTypeModel $value)
    {
        if (empty($this->_properties[$visibility])) {
            $this->_properties[$visibility] = [];
        }

        $this->_properties[$visibility][$name] = $value;
    }

    /**
     * @param array $properties
     */
    public function setProperties(array $properties)
    {
        $this->_properties = $properties;
    }

    public function getProperties()
    {
        return $this->_properties;
    }

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->_className = get_class($entity);
    }

}