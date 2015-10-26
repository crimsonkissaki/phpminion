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
class ClassModel
{

    /**
     * Class's name
     *
     * @var string
     */
    private $name;

    /**
     * Class's namespace
     *
     * @var string
     */
    private $nameSpace;

    /**
     * Class extended by target class, if any
     *
     * @var string
     */
    private $extends;

    /**
     * Class(es) implemented by target class, if any
     *
     * @var array
     */
    private $implements = [];

    /**
     * Use statement includes, if any
     *
     * @var array
     */
    private $uses = [];

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
    //private $_methods = [];

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
    public function getNameSpace()
    {
        return $this->nameSpace;
    }

    /**
     * @param string $nameSpace
     */
    public function setNameSpace($nameSpace)
    {
        $this->nameSpace = $nameSpace;
    }

    /**
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param string $extends
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    /**
     * @return array
     */
    public function getImplements()
    {
        return $this->implements;
    }

    /**
     * @param array $implements
     */
    public function setImplements($implements)
    {
        $this->implements = $implements;
    }

    /**
     * @return array
     */
    public function getUses()
    {
        return $this->uses;
    }

    /**
     * @param array $uses
     */
    public function setUses($uses)
    {
        $this->uses = $uses;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->_properties;
    }

    /**
     * @param array $properties
     */
    public function setProperties($properties)
    {
        $this->_properties = $properties;
    }
}