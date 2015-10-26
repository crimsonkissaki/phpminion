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

use PHPMinion\Utilities\ClassAnalyzer\Models\ClassModel;
use PHPMinion\Utilities\ClassAnalyzer\ClassAnalysis\ClassAnalysis;
use PHPMinion\Utilities\ClassAnalyzer\PropertyAnalysis\PropertyAnalysis;
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
     * Representation of the class
     *
     * @var ClassModel
     */
    private $_classModel;

    /**
     * @var ClassAnalysis
     */
    private $_classAnalysis;

    /**
     * @var PropertyAnalysis
     */
    private $_propertyAnalysis;

    public function __construct()
    {
        $this->_classAnalysis = new ClassAnalysis();
        $this->_propertyAnalysis = new PropertyAnalysis();
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

        $this->_classModel = $this->_classAnalysis->analyze($this->_class, $this->_refClass);
        $this->_classModel->setProperties(
            $this->_propertyAnalysis->analyze($this->_class, $this->_refClass)
        );

        return $this;
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
                $this->_refClass = new \ReflectionObject($class);

                return true;
            }
            if (is_string($class)) {
                $this->_class = new $class();
                $this->_refClass = new \ReflectionClass($class);

                return true;
            }
        } catch (\Exception $e) {
            throw new ClassAnalyzerException("Unknown error while attempting to instantiate '{$class}': '{$e->getMessage()}'");
        }
    }

}