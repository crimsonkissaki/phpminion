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

/**
 * Class ObjectModel
 *
 * Model to hold object data
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectModel extends DataTypeModel
{

    /**
     * @var string
     */
    private $name;

    private $properties = [];

    //public $methods = [];

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addProperty(PropertyModel $property)
    {
        $visibility = $property->visibility;
        if (empty($this->properties[$visibility])) {
            $this->properties[$visibility] = [];
        }

        $this->properties[$visibility][$property->name] = $property;
    }

    public function getProperties()
    {
        return $this->properties;
    }

}