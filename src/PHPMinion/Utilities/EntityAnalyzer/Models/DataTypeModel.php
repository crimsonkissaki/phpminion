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
     * Name of the property, if any
     *
     * @var string
     */
    protected $propertyName;

    /**
     * Data type the model represents
     *
     * @var string
     */
    protected $dataType;

    /**
     * Data visibility scope
     *
     * @var string
     */
    protected $visibility = 'public';

    /**
     * Values depending on data model type
     *
     * Scalar is a simple value
     * Array is key => value
     * Object is property => value
     *
     * @var mixed
     */
    protected $value;

    /**
     * @return string
     */
    public function getPropertyName()
    {
        return $this->propertyName;
    }

    /**
     * @param string $propertyName
     */
    public function setPropertyName($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->dataType;
    }

    /**
     * Allows overrides by children
     *
     * @param string $dataType
     */
    protected function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param string
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function __construct($entity)
    {
        $this->_dataType = strtolower(gettype($entity));
    }

}