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

namespace PHPMinion\Utilities\ClassAnalyzer\Models;

/**
 * Class PropertyModel
 *
 * Model to hold object property data
 *
 * @created     October 23, 2015
 * @version     0.1
 */
class PropertyModel
{

    /**
     * Name of the property
     *
     * @var string
     */
    private $name;

    /**
     * Visibility of the property
     *
     * Values are public, private, protected, static, constant.
     *
     * @var string
     */
    private $visibility;

    /**
     * Is the property static
     *
     * @var bool
     */
    private $isStatic;

    /**
     * Setter method if any
     *
     * @var string
    private $setter;
     */

    /**
     * Current property value, if any
     *
     * @var mixed
     */
    private $currentValue;

    /**
     * Current property value data type
     *
     * @var string
     */
    private $currentValueDataType;

    /**
     * Default property value, if any
     *
     * @var mixed
    private $defaultValue;
     */

    /**
     * Default property value data type
     *
     * @var string
    private $defaultValueDataType;
     */

    /**
     * Class name of object property types
     *
     * @var string
     */
    private $className;

    /**
     * Class namespace of object property types
     *
     * @var string
     */
    private $classNamespace;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param string $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return boolean
     */
    public function isIsStatic()
    {
        return $this->isStatic;
    }

    /**
     * @param boolean $isStatic
     */
    public function setIsStatic($isStatic)
    {
        $this->isStatic = $isStatic;
    }

    /**
     * @return string
     */
    public function getSetter()
    {
        return $this->setter;
    }

    /**
     * @param string $setter
     */
    public function setSetter($setter)
    {
        $this->setter = $setter;
    }

    /**
     * @return mixed
     */
    public function getCurrentValue()
    {
        return $this->currentValue;
    }

    /**
     * @param mixed $currentValue
     */
    public function setCurrentValue($currentValue)
    {
        $this->currentValue = $currentValue;
    }

    /**
     * @return string
     */
    public function getCurrentValueDataType()
    {
        return $this->currentValueDataType;
    }

    /**
     * @param string $currentValueDataType
     */
    public function setCurrentValueDataType($currentValueDataType)
    {
        $this->currentValueDataType = $currentValueDataType;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param mixed $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getDefaultValueDataType()
    {
        return $this->defaultValueDataType;
    }

    /**
     * @param string $defaultValueDataType
     */
    public function setDefaultValueDataType($defaultValueDataType)
    {
        $this->defaultValueDataType = $defaultValueDataType;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getClassNamespace()
    {
        return $this->classNamespace;
    }

    /**
     * @param string $classNamespace
     */
    public function setClassNamespace($classNamespace)
    {
        $this->classNamespace = $classNamespace;
    }

    /**
     * ORM data obtained from Entity class
     *
     * @var OrmData
    private $ormData;
     */



}