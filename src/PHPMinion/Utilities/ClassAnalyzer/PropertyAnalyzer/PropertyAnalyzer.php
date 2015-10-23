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

namespace PHPMinion\Utilities\ClassAnalyzer\PropertyAnalyzer;

/**
 * Class PropertyAnalyzer
 *
 * Puts class properties under a reflection microscope
 *
 * Right now this is going to be messy as hell.
 * I'll clean it up once I know a better direction to go in.
 *
 * @created     October 23, 2015
 * @version     0.1
 */
class PropertyAnalyzer
{

    /**
     * @var PropertyAnalyzer
     */
    private static $_instance;

    private function __construct() {}

    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new PropertyAnalyzer();
        }

        return self::$_instance;
    }

    /**
     * Analyzes a class's properties
     *
     * @param \ReflectionClass $class
     * @return array
     */
    public static function analyze(\ReflectionClass $class)
    {
        $propertyModels = self::getInstance()->createModelsForClassProperties($class);

        return $propertyModels;
    }

    /**
     * Creates PropertyModel objects for all class properties
     *
     * @param \ReflectionClass $class
     * @return PropertyModels[]
     */
    private function createModelsForClassProperties(\ReflectionClass $class)
    {
        $refProps = $this->getReflectionProperties($class);
        $propertyModels = $this->getPropertiesDetails($refProps);

        return $propertyModels;
    }

    // testing if i really need to go through the work of doing this by visibility
    private function getReflectionProperties(\ReflectionClass $class)
    {
        $byVis = $this->getReflectionPropertiesByVisibility($class);

        $props = [];
        foreach ($byVis as $vis => $propsArr) {
            foreach ($propsArr as $key => $prop) {
                $props[] = $prop;
            }
        }

        return $props;
    }

    /**
     * Returns an associative array of object properties by visibility
     *
     * <code>
     * $props = [
     *   'constant' => [
     *     \ReflectionProperty,
     *     \ReflectionProperty,
     *   ],
     *   'public' => [
     *     \ReflectionProperty,
     *     \ReflectionProperty,
     *   ],
     *   ...
     * ];
     * </code>
     *
     * @param  \ReflectionClass $class
     * @return array
     */
    private function getReflectionPropertiesByVisibility(\ReflectionClass $class)
    {
        $props = [];
        if ($const = $class->getConstants()) {
            $props['constant'] = $const;
        }
        if ($priv = $class->getProperties(\ReflectionProperty::IS_PRIVATE)) {
            $props['private'] = $priv;
        }
        if ($prot = $class->getProperties(\ReflectionProperty::IS_PROTECTED)) {
            $props['protected'] = $prot;
        }
        if ($pub = $class->getProperties(\ReflectionProperty::IS_PUBLIC)) {
            $props['public'] = $pub;
        }
        if ($stat = $class->getProperties(\ReflectionProperty::IS_STATIC)) {
            $props['static'] = $stat;
        }

        return $props;
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

    private function getPropertyDetails($key, $value)
    {

    }

}