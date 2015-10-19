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

namespace PHPMinion\Utilities\ObjectAnalyzer\Workers;

use PHPMinion\Utilities\Dbug\Dbug;
use PHPMinion\Utilities\ObjectAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\ObjectAnalyzer\Models\PropertyModel;
use PHPMinion\Utilities\ObjectAnalyzer\Models\MethodModel;

/**
 * Class ObjectWorker
 *
 * Builds up the ObjectModel data
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class PropertyWorker
{

    private $_obj;

    /**
     * @var \ReflectionClass
     */
    private $_refObj;

    public function setObj($obj)
    {
        $this->_obj= $obj;
    }

    public function setRefObj(\ReflectionClass $refObj)
    {
        $this->_refObj = $refObj;
    }

    /**
     * Gets an array of class properties through a reflection class instance
     *
     * @return  array
     */
    public function getClassProperties()
    {
        $refProps = $this->getReflectionProperties();

        return $this->getClassPropertiesDetails($refProps);
    }

    private function getReflectionProperties()
    {
        $obj = $this->_refObj;

        $props = [];
        $props['constant'] = $obj->getConstants();
        $props['private'] = $obj->getProperties(\ReflectionProperty::IS_PRIVATE);
        $props['protected'] = $obj->getProperties(\ReflectionProperty::IS_PROTECTED);
        $props['public'] = $obj->getProperties(\ReflectionProperty::IS_PUBLIC);
        $props['static'] = $obj->getProperties(\ReflectionProperty::IS_STATIC);

        return $props;
    }

    /**
     * Gets an array of PropertyModel objects for the class's properties
     */
    private function getClassPropertiesDetails($classProperties)
    {
        $models = [];
        foreach ($classProperties as $visibility => $properties) {
            if (!empty($properties)) {
                $models[$visibility] = $this->getPropertiesDetails($visibility, $properties);
            }
        }

        return $models;
    }

    /**
     * Gets details for an array of properties
     *
     * Constants are a problem here since they're set as an associative array
     * and not numeric, so 'as key => value' works while 'as $property' does not.
     *
     * @param   string $visibility Visibility scope of properties
     * @param   array  $properties Array of \ReflectionProperties objects
     * @return  array
     */
    private function getPropertiesDetails($visibility, $properties)
    {
        $results = [];
        foreach ($properties as $key => $value) {
            // it causes problems down the line to have static
            // properties set in the other visibilities
            $prop = $this->getPropertyDetails($visibility, $key, $value);
            if ($visibility !== 'static' && empty($prop->isStatic)) {
                array_push($results, $prop);
            }
            if ($visibility === 'static') {
                array_push($results, $prop);
            }
        }

        return $results;
    }

    /**
     * Gets details for an object property
     *
     * Looping through an array of all class properties returned by
     * a \ReflectionClass's getProperties() method returns is interesting
     * because 'constant' properties are returned as an associative array
     * of 'name' => 'value', while every other visibility level is returned
     * as a numerically indexed array of 'N' => \ReflectionProperty objects.
     *
     * @param    string        $visibility Property visibility
     * @param    string|int    $key        Property name or a numeric index
     * @param    string|object $value      Property value or \ReflectionProperty object
     * @return  PropertyModel
     */
    private function getPropertyDetails($visibility, $key, $value)
    {
        $model = new PropertyModel();
        $model->name = (is_object($value)) ? $value->name : $key;
        //$model->setter = $this->findPropertySetterIfExists($result->name, $this->methods);
        $model->visibility = $visibility;
        $model->isStatic = (is_object($value)) ? $value->isStatic() : false;
        $model->currentValue = $this->getCurrentPropertyValue($visibility, $value);
        $model->currentValueDataType = gettype($model->currentValue);
        $model->defaultValue = $this->getPropertyDefaultValue($visibility, $value);
        $model->defaultValueDataType = gettype($model->defaultValue);
        $classData = $this->getValueClassData($model->currentValue);
        $model->className = $classData['className'];
        $model->classNamespace = $classData['classNamespace'];

        return $model;
    }

    /**
     * Gets the current value for a property, if any
     *
     * TODO: need to make sure this is working right with stdClass and custom objects
     *
     * 'Constant' properties just need the value string returned.
     * All other visibility levels are a \ReflectionProperty object
     * whose getValue() method requires an actual instance of the
     * owning class to determine the default value.
     *
     * @param   string        $visibility Property visibility
     * @param   string|object $value      String or \ReflectionProperty object
     * @return  string
     */
    private function getCurrentPropertyValue($visibility, $value)
    {
        if ($visibility === 'constant') {
            return $value;
        }

        if ($value->isPrivate() || $value->isProtected()) {
            $value->setAccessible(true);
        }

        if ($visibility === 'static') {
            return $value->getValue();
        }

        /*
        if ($value->class === 'stdClass') {
            $name = $value->name;
            return $this->_obj->$name;
        }
        */

        $name = $value->name;

        return $this->_obj->$name;
    }

    /**
     * Gets the default value for a property, if any
     *
     * TODO: need to make sure this is working right with stdClass and custom objects
     *
     * 'Constant' properties just need the value string returned.
     * All other visibility levels are a \ReflectionProperty object
     * whose getValue() method requires an actual instance of the
     * owning class to determine the default value.
     *
     * @param   string        $visibility Property visibility
     * @param   string|object $value      String or \ReflectionProperty object
     * @return  string
     */
    private function getPropertyDefaultValue($visibility, $value)
    {
        if ($visibility === 'constant') {
            return $value;
        }
        if ($value->isPrivate() || $value->isProtected()) {
            $value->setAccessible(true);
        }

        if ($value->class === 'stdClass') {
            return null;
        }

        // do not have to pass a class instance if you use ReflectionClass::getDefaultProperties
        return (is_object($this->classInstance)) ? $value->getValue($this->classInstance) : 'unknown';
    }

    /**
     * Gets class data for values that are objects
     *
     * This method consumes the return value of a \ReflectionProperty
     * object's getValue() method, and if the default value is an object
     * getValue() returns an instance of that object.
     *
     * @param   mixed $value Hopefully a value object instance
     * @return  array
     */
    private function getValueClassData($value)
    {
        $data = ['className' => null, 'classNamespace' => null];

        if (!is_object($value)) {
            return $data;
        }

        $className = get_class($value);
        if (($pos = strrpos($className, '\\')) === false) {
            $data['className'] = $className;
        } else {
            $data['className'] = substr($className, $pos + 1);
            $data['classNamespace'] = substr($className, 0, $pos);
        }

        return $data;
    }

    /**
     * Gets the name of a property's setter, if one exists
     *
     * This method has to make the assumption that a property's
     * setter will be named after it, e.g. a property called "totalCount"
     * has a setter with the name "setTotalCount".
     *
     * @param   string $name         Property name
     * @param   array  $classMethods Array of MethodData objects
     * @return  array
     */
    private function findPropertySetterIfExists($name, $classMethods)
    {
        foreach ($classMethods as $methods) {
            if (!empty($methods)) {
                foreach ($methods as $method) {
                    if (stripos($method->name, "set{$name}") !== false) {
                        return $method->name;
                    }
                }
            }
        }

        return false;
    }

}
