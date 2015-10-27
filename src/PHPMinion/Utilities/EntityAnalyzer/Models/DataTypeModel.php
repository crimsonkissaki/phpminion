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

use PHPMinion\Utilities\EntityAnalyzer\Renderers\DataTypeModelRenderer;

/**
 * Class DataTypeModel
 *
 * Parent model for all EntityEntityAnalyzer models
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
abstract class DataTypeModel
{

    /**
     * Data type the model represents
     *
     * @var string
     */
    protected $_dataType;

    /**
     * Data visibility scope
     *
     * @var string
     */
    protected $_visibility = 'public';

    /**
     * Values depending on data model type
     *
     * Scalar is a simple value
     * Array is key => value
     * Object is property => value
     *
     * @var mixed
     */
    protected $_value;

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->_dataType;
    }

    /**
     * Allows overrides by children
     *
     * @param string $dataType
     */
    protected function setDataType($dataType)
    {
        $this->_dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->_visibility;
    }

    /**
     * @param string
     */
    public function setVisibility($visibility)
    {
        $this->_visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->_value;
    }

    public function __construct($entity)
    {
        $this->_dataType = strtolower(gettype($entity));
    }

}