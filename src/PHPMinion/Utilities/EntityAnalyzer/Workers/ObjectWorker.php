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

/*
use PHPMinion\Utilities\Dbug\Dbug;
use PHPMinion\Utilities\EntityAnalyzer\Models\PropertyModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\MethodModel;
use PHPMinion\Utilities\EntityAnalyzer\Workers\PropertyWorker;
*/
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

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
class ObjectWorker implements DataTypeWorkerInterface
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

    public function __construct()
    {
        //$this->_model = new ObjectModel();
    }

    /**
     * TODO: this fucks up when passed a stdClass - cant use \ReflectionProperty->getValue()
     *
     * @return ObjectModel
     */
    public function createModel($entity)
    {
        $this->validateTargetObj($entity);

        $model = new ObjectModel();
        $model->setDataType('object');
        $model->setRendererType('object');

        return $model;

        /*
        $this->setUp($entity);

        $this->_propertyWorker = new PropertyWorker($this->_obj, $this->_refObj);

        $model = new ObjectModel();
        $model->setName($this->getObjectName($this->_refObj));
        //$model->properties = $this->_propertyWorker->getClassProperties();
        $properties = $this->_propertyWorker->getReflectionProperties();
        foreach ($properties as $vis => $visProps) {
            foreach( $visProps as $name => $value) {
                if ($propModel = $this->_propertyWorker->new_getPropertyDetails($vis, $name, $value)) {
                    $model->addProperty($propModel);
                }
            }
        }

        \PHPMinion\Utils::dbug($model, "model in objectworker->workobject()");

        return $model;
        */
    }

    /**
     * Sets up ObjectWorker
     *
     * TODO: this will probably have issues if passing in a class name string and it requires __construct() args to instantiate
     *
     * @param mixed $obj
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function setUp($obj)
    {

        if (is_object($obj)) {
            $this->_obj = $obj;
            $this->_refObj = new \ReflectionObject($obj);
        }

        if (is_string($obj)) {
            try {
                $this->_obj = new $obj();
                $this->_refObj = new \ReflectionClass($obj);
            } catch (\Exception $e) {
                throw new EntityAnalyzerException("Unknown error while attempting to instantiate '{$obj}': '{$e->getMessage()}'\n\nCreate an object instance and try that instead.");
            }
        }

        return true;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $obj
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateTargetObj($obj)
    {
        if (is_object($obj)) {
            return true;
        }
        if (is_string($obj) && class_exists($obj)) {
            return true;
        }

        throw new EntityAnalyzerException("ObjectWorker only accept objects or fully qualified class names: '" . gettype($obj) . "' supplied.");
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