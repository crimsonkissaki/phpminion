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

namespace PHPMinion\Utilities\EntityAnalyzer\Workers;

use PHPMinion\Utilities\Dbug\Dbug;
use PHPMinion\Utilities\EntityAnalyzer\EntityAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\PropertyModel;
//use PHPMinion\Utilities\EntityAnalyzer\Models\MethodModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * Class PropertyWorker
 *
 * Builds up the PropertyModel data
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class PropertyWorker implements DataTypeWorkerInterface
{

    /**
     * @var EntityAnalyzerInterface
     */
    private $_entityAnalyzer;

    /**
     * Target object instance to analyze
     *
     * @var object
     */
    private $_obj;

    /**
     * Target object's ReflectionClass instance
     *
     * @var \ReflectionClass $_refObj
     */
    private $_refObj;

    /**
     * @param object           $targetObj
     * @param \ReflectionClass $reflectionObj
     * @throws EntityAnalyzerException
    public function __construct($targetObj, \ReflectionClass $reflectionObj)
    {
        if (!is_object($targetObj)) {
            throw new EntityAnalyzerException("PropertyWorker \$targetObj must be a valid object instance.");
        }

        $this->_entityAnalyzer = new EntityEntityAnalyzer();
        $this->_obj = $targetObj;
        $this->_refObj = $reflectionObj;
    }
     */

    /**
     * @inheritDoc
     */
    public function createModel($entity)
    {
        $model = new PropertyModel();

        return $model;
    }

    /**
     * Returns object properties represented as PropertyModel objects
     *
     * @return  PropertyModel[]
     */
    public function getClassProperties()
    {
        $refProps = $this->getReflectionProperties();

        return $this->getClassPropertiesDetails($refProps);
    }


    /**
     * Returns an associative array of visibility => [PropertyModel objects] for the class's properties
     *
     * @param  array $classProps
     * @return array
     */
    private function getClassPropertiesDetails(array $classProps)
    {
        $models = [];
        foreach ($classProps as $visibility => $properties) {
            if (!empty($properties)) {
                $models[$visibility] = $this->getPropertiesDetails($visibility, $properties);
            }
        }

        return $models;
    }


    public function new_getPropertyDetails($visibility, $key, $value)
    {
        $prop = $this->getPropertyDetails($visibility, $key, $value);
        if ($visibility !== 'static' && empty($prop->isStatic)) {
            return $prop;
        }
        if ($visibility === 'static') {
            return $prop;
        }

        return false;
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
        $model->setter = 'TODO: get this working!';
        $model->visibility = $visibility;
        $model->isStatic = (is_object($value)) ? $value->isStatic() : false;

        //$model->currentValue = $this->getCurrentPropertyValue($visibility, $value);
        //$model->currentValueDataType = gettype($model->currentValue);
        //$model->defaultValue = $this->getPropertyDefaultValue($visibility, $value);
        //$model->defaultValueDataType = gettype($model->defaultValue);
        $model->defaultValue = 'TODO: get this working!';
        $model->defaultValueDataType = 'TODO: get this working!';


        $actualValue = $this->getCurrentPropertyValue($visibility, $value);
        $model->currentValue = $this->getAnalyzedValueIfRequired($actualValue);
        $model->currentValueDataType = gettype($actualValue);
        //$classData = $this->getValueClassData($model->currentValue);
        $classData = $this->getValueClassData($actualValue);
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

        return $value->getValue($this->_obj);
    }

    /**
     * Returns an analyzed DataTypeModel or the actual value, depending
     *
     * @param mixed $value
     * @return DataTypeModel|string
     */
    private function getAnalyzedValueIfRequired($value)
    {
        if (is_object($value)) {
            return 'OBJECT ('.get_class($value).')';
            //return $this->_entityAnalyzer->analyze($value);
        }
        if (is_array($value)) {
            \PHPMinion\Utilities\Dbug\Dbug::color('calling array validation for an array in a property value!', 'orange')->ignore()->dump();
            $analyzedArray = $this->_entityAnalyzer->analyze($value);
            \PHPMinion\Utils::dbug($analyzedArray, "analyzed array in getAnalyzedValueIfRequired()");
            return $analyzedArray;
        }

        return $value;
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
