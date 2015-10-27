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

namespace PHPMinion\Utilities\ClassAnalyzer\PropertyAnalysis;

use PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalyzerException;

/**
 * Class PropertyAnalysis
 *
 * Puts class properties under a reflection microscope
 *
 * Right now this is going to be messy as hell.
 * I'll clean it up once I know a better direction to go in.
 *
 * @created     October 23, 2015
 * @version     0.1
 */
class PropertyAnalysis
{

    /**
     * Object under the microscope
     *
     * @var object
     */
    private $_obj;

    /**
     * ReflectionClass of object
     *
     * @var \ReflectionClass
     */
    private $_refObj;

    /**
     * Analyzes a class's properties
     *
     * @param object           $object
     * @param \ReflectionClass $refObject
     * @return PropertyModel[]
     */
    public function analyze($object, \ReflectionClass $refObject)
    {
        $this->validateArgs($object, $refObject);

        $this->_obj = $object;
        // stdClass does not play nicely with reflection
        if (get_class($object) === 'stdClass') {
            $propertyModels = $this->getPropertiesDetails($this->_obj);
        } else {
            $this->_refObj = $refObject;
            $propertyModels = $this->createModelsForClassProperties();
        }

        return $propertyModels;
    }

    /**
     * Validates args passed into PropertyAnalysis
     *
     * @param object           $object
     * @param \ReflectionClass $refObject
     * @return bool
     * @throws ClassAnalyzerException
     */
    private function validateArgs($object, $refObject)
    {
        if (!is_object($object) || !$refObject instanceof \ReflectionClass || (get_class($object) !== $refObject->getName())) {
            throw new ClassAnalyzerException("PropertyAnalysis must receive an object and it's reflection class as arguments.");
        }

        return true;
    }

    /**
     * Creates PropertyModel objects for all class properties
     *
     * @return PropertyModels[]
     */
    private function createModelsForClassProperties()
    {
        $const = $this->_refObj->getConstants();
        $props = $this->_refObj->getProperties();
        $refProps = array_merge($const, $props);
        $propertyModels = $this->getPropertiesDetails($refProps);

        return $propertyModels;
    }

    /**
     * Gets details for an array of properties
     *
     * Constants are a problem here since they're set as an associative array
     * and not numeric, so 'as key => value' works while 'as $property' does not.
     *
     * @param   array  $properties Array of \ReflectionProperties objects
     * @return  array
     */
    private function getPropertiesDetails($properties)
    {
        $results = [];
        foreach ($properties as $key => $value) {
            //$results[] = ['key' => $key, 'value' => $value];
            $results[] = $this->getPropertyDetails($key, $value);
        }

        return $results;
    }

    /**
     * Gets details for an object property
     *
     * Looping through an array of all class properties returned by
     * a \ReflectionClass's getProperties() method is interesting
     * because 'constant' properties are returned as an associative array
     * of 'name' => 'value', while every other visibility level is returned
     * as a numerically indexed array of 'N' => \ReflectionProperty objects.
     *
     * @param    string|int    $key        Property name or a numeric index
     * @param    string|object $property   Property value or \ReflectionProperty object
     * @return  PropertyModel
     */
    private function getPropertyDetails($key, $property)
    {
        // have to differentiate between stdClasses and not here
        $model = new PropertyModel();
        $model->setName(((is_object($property)) ? $property->getName(): $key));
        //$model->setter = $this->findPropertySetterIfExists($result->name, $this->methods);
        $model->setVisibility($this->getPropertyVisibility($property));
        $model->setIsStatic((is_object($property)) ? $property->isStatic() : false);
        $model->setCurrentValue($this->getCurrentPropertyValue($property));
        $model->setCurrentValueDataType(gettype($model->getCurrentValue()));

        $classData = $this->getValueClassData($model->getCurrentValue());
        $model->setClassName($classData['className']);
        $model->setClassNamespace($classData['classNamespace']);

        return $model;
    }

    /**
     * Determines what visibility/scope a property falls under
     *
     * @param  mixed $property
     * @return string
     */
    private function getPropertyVisibility($property)
    {
        // order is important so we don't call methods on stdClass values
        switch (true) {
            case (get_class($this->_obj) === 'stdClass'):
                // stdClass will blow up everything else
                return 'public';
            case (!is_object($property)):
                // constants cause issues since they're strings
                return 'constant';
            /*
             * TODO: what to do with static properties?
            case ($property->isStatic()):
                // static is a type unto itself
                return 'static';
            */
            case ($property->isPublic()):
                return 'public';
            case ($property->isPrivate()):
                return 'private';
            case ($property->isProtected()):
                return 'protected';
            default:
                return 'UNKNOWN_VISIBILITY';
        }
    }

    /**
     * Gets the current value for a property, if any
     *
     * 'Constant' properties just need the value string returned.
     * All other visibility levels are a \ReflectionProperty object
     * whose getValue() method requires an actual instance of the
     * owning class to determine the default value.
     *
     * @param   string|object $property      String or \ReflectionProperty object
     * @return  string
     */
    private function getCurrentPropertyValue($property)
    {
        if (!is_object($property)) {
            return $property;
        }

        if ($property->isPrivate() || $property->isProtected()) {
            $property->setAccessible(true);
        }

        if ($property->isStatic()) {
            return $property->getValue();
        }

        return $property->getValue($this->_obj);
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
}