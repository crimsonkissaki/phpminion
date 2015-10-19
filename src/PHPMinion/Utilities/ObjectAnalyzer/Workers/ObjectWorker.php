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

use PHPMinion\Utilities\ObjectAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\ObjectAnalyzer\Models\PropertyModel;
use PHPMinion\Utilities\ObjectAnalyzer\Models\MethodModel;
use PHPMinion\Utilities\ObjectAnalyzer\Workers\PropertyWorker;

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
class ObjectWorker
{

    /**
     * Target object to analyze
     *
     * @var object
     */
    private $_obj;

    /**
     * Target object's \ReflectionClass
     *
     * @var \ReflectionClass
     */
    private $_refObj;

    /**
     * @var PropertyWorker
     */
    private $_propertyWorker;

    private $_methodWorker;

    public function setObject($obj)
    {
        $this->_obj = $obj;
    }

    public function setReflectionObject(\ReflectionClass $obj)
    {
        $this->_refObj = $obj;
    }

    public function __construct()
    {
        $this->_model = new ObjectModel();
    }

    /**
     * TODO: this fucks up when passed a stdClass - cant use \ReflectionProperty->getValue()
     *
     * @return ObjectModel
     */
    public function analyze()
    {
        $this->_propertyWorker = new PropertyWorker();
        $this->_propertyWorker->setObj($this->_obj);
        $this->_propertyWorker->setRefObj($this->_refObj);

        $model = new ObjectModel();
        $model->name = $this->getObjectName($this->_refObj);
        $model->properties = $this->_propertyWorker->getClassProperties();
        //$model->methods = $this->getObjectMethods($this->_obj);

        return $model;
    }

    private function getObjectName(\ReflectionClass $obj)
    {
        return $obj->getName();
    }

    private function getObjectMethods(\ReflectionClass $obj)
    {
        return [];
    }


}