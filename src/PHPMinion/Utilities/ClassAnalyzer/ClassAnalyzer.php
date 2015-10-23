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

namespace PHPMinion\Utilities\ClassAnalyzer;

use PHPMinion\Utilities\ClassAnalyzer\PropertyAnalyzer\PropertyAnalyzer;
use PHPMinion\Utilities\ClassAnalyzer\Exceptions\ClassAnalyzerException;

/**
 * Class ClassAnalyzer
 *
 * Puts classes under a reflection microscope
 *
 * Right now this is going to be messy as hell.
 * I'll clean it up once I know a better direction to go in.
 *
 * @created     October 23, 2015
 * @version     0.1
 */
class ClassAnalyzer
{

    /**
     * Name of class to be analyzed
     *
     * @var  string
     */
    private $_className;

    /**
     * Instance of class to be analyzed
     *
     * @var  object
     */
    private $_class;

    /**
     * \ReflectionClass instance of class being analyzed
     *
     * @var  \ReflectionClass
     */
    private $_refClass;

    /**
     * The class's properties by visibility (scope)
     *
     * @var array
     */
    private $_properties = [];

    /**
     * The class's methods by visibility (scope)
     *
     * @var array
     */
    private $_methods = [];

    public function getProperties()
    {
        return $this->_properties;
    }

    public function getMethods()
    {
        return $this->_methods;
    }

    /**
     * Analyzes the class so you don't have to
     *
     * @param object|string $class
     * @return ClassAnalyzer
     */
    public function analyze($class)
    {
        $this->validateClass($class);
        $this->setUp($class);

        $this->_properties = ''; //PropertyAnalyzer::analyze($this->_refClass);
        $this->_methods = '';

        return $this;
    }

    /**
     * Sets up ClassAnalyzer for work
     *
     * @param object|string $class
     * @return bool
     * @throws ClassAnalyzerException
     */
    private function setUp($class)
    {
        try {
            if (is_object($class)) {
                $this->_class = $class;
                $this->_className = get_class($class);
                $this->_refClass = new \ReflectionObject($class);

                return true;
            }
            if (is_string($class)) {
                $this->_class = new $class();
                $this->_className = $class;
                $this->_refClass = new \ReflectionClass($class);

                return true;
            }
        } catch (\Exception $e) {
            throw new ClassAnalyzerException("Unknown error while attempting to instantiate '{$class}': '{$e->getMessage()}'");
        }
    }

    /**
     * Makes sure we can work with what we're given
     *
     * @param  mixed $class
     * @return bool
     * @throws ClassAnalyzerException
     */
    private function validateClass($class)
    {
        if (is_object($class) || (is_string($class) && class_exists($class))) {
            return true;
        }

        throw new ClassAnalyzerException("ClassAnalyzer can only accept object instances or fully qualified class names. " . gettype($class) . " provided.");
    }

}