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

namespace PHPMinion;

use ass\XmlSecurity\Exception\InvalidArgumentException;

/**
 * Primary entry point for suite tools
 *
 * Can be used as a simple facade gateway or bypassed entirely if you want to
 * directly instantiate the * utility classes.
 */
class PHPMinion
{

    /**
     * Path to PHPMinion
     *
     * @var string
     */
    private $_pathToPM;

    /**
     * Path to the project root
     *
     * @var string
     */
    private $_projectRoot;

    /**
     * @var PHPMinion
     */
    private static $_instance;

    /**
     * Container array for "fake" singletons
     *
     * @var array
     */
    private $_classes = [];

    public function getPathToPM()
    {
        return $this->_pathToPM;
    }

    public function getProjectRoot()
    {
        return $this->_projectRoot;
    }

    private function __construct()
    {
        $this->_pathToPM = dirname(__FILE__) . DIRECTORY_SEPARATOR;
        $this->_projectRoot = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))) . DIRECTORY_SEPARATOR;
    }

    /**
     * Gets an instance of PHPMinion
     *
     * @return PHPMinion
     */
    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new PHPMinion();
        }

        return self::$_instance;
    }

    /**
     * Instantiates a utility class & saves it in PHPMinion::$_classes[]
     *
     * This acts as a repository for long-running instances of various
     * utility classes, which is most helpful if you're debugging through
     * multiple files and want to keep the results together.
     *
     * If you do not pass in an alias the class name will be used to
     * reference the class instance.
     *
     * By design this will NOT allow you to overwrite an existing
     * class instance.
     *
     * @param string      $class Name of the desired utility class
     * @param null|string $alias An alias to reference the instance
     * @throws  \InvalidArgumentException
     */
    public function create($class, $alias = null)
    {
        $needle = strtolower($class);
        // $_classes array key to store the instance under
        $key = (!is_null($alias)) ? strtolower($alias) : $class;
        $className = 'PHPMinion\Utilities\\' . ucfirst($class);

        if (isset($this->_classes[$key])) {
            throw new \InvalidArgumentException("An instance of '{$class}' already exists under alias '{$key}'");
        }

        if (!class_exists($className)) {
            throw new \InvalidArgumentException("Class '{$className}' does not exist.");
        }

        $this->_classes[$key] = new $className;

        return $this->_classes[$key];
    }

    /**
     * Creates the class instance if needed and returns it
     *
     * Use this if the code you're debugging executes multiple times
     * and might try to re-create the instance.
     *
     * @param string $class
     * @param null   $alias
     * @return mixed
     */
    public function createOrGet($class, $alias = null)
    {
        $key = (!is_null($alias)) ? strtolower($alias) : $class;

        if (!isset($this->_classes[$key])) {
            $this->create($class, $alias);
        }

        return $this->get($alias);
    }

    /**
     * Returns a previously created utility class instance by alias
     *
     * @param   string $alias
     * @return  mixed
     * @throws  \InvalidArgumentException
     */
    public function get($alias)
    {
        $needle = strtolower($alias);

        if (!isset($this->_classes[$needle])) {
            throw new \InvalidArgumentException("There is no class created under the alias '{$alias}'");
        }

        return $this->_classes[$needle];
    }

}

