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
use PHPMinion\Utilities\ObjectAnalyzer\Exceptions\ObjectAnalyzerException;
use PHPMinion\Utilities\ObjectAnalyzer\Renderer\ObjectModelRendererInterface;
use PHPMinion\Utilities\ObjectAnalyzer\Renderer\ObjectModelRenderer;

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

    /**
     * @var ObjectModelRendererInterface
     */
    private $_renderer;

    public function setRenderer(ObjectModelRendererInterface $renderer)
    {
        $this->_renderer = $renderer;
    }

    public function getRenderer()
    {
        return $this->_renderer;
    }

    /**
     * TODO: need to allow custom setting of object model renderers
     */
    public function __construct()
    {
        $this->_model = new ObjectModel();
        $this->setRenderer(new ObjectModelRenderer());
    }

    /**
     * TODO: this fucks up when passed a stdClass - cant use \ReflectionProperty->getValue()
     *
     * @return ObjectModel
     */
    public function analyze($obj)
    {
        $this->setUp($obj);

        $this->_propertyWorker = new PropertyWorker($this->_obj, $this->_refObj);

        $model = new ObjectModel();
        $model->name = $this->getObjectName($this->_refObj);
        //$properties = $this->_propertyWorker->getClassProperties();
        $model->properties = $this->_propertyWorker->getClassProperties();
        //$model->methods = $this->getObjectMethods($this->_obj);

        $renderedModel = $this->_renderer->renderObjectModel($model);

        return $renderedModel;
    }

    /**
     * Sets up ObjectWorker
     *
     * TODO: this will probably have issues if passing in a class name string and it requires __construct() args to instantiate
     *
     * @param mixed $obj
     * @return bool
     * @throws ObjectAnalyzerException
     */
    private function setUp($obj)
    {
        $this->validateTargetObj($obj);

        if (is_object($obj)) {
            $this->_obj = $obj;
            $this->_refObj = new \ReflectionObject($obj);
        }

        if (is_string($obj)) {
            try {
                $this->_obj = new $obj();
                $this->_refObj = new \ReflectionClass($obj);
            } catch (\Exception $e) {
                throw new ObjectAnalyzerException("Unknown error while attempting to instantiate '{$obj}': '{$e->getMessage()}'\n\nCreate an object instance and try that instead.");
            }
        }

        return true;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $obj
     * @return bool
     * @throws ObjectAnalyzerException
     */
    private function validateTargetObj($obj)
    {
        if (is_object($obj)) {
            return true;
        }
        if (is_string($obj) && class_exists($obj)) {
            return true;
        }

        throw new ObjectAnalyzerException("ObjectWorker only accept objects or fully qualified class names: '" . gettype($obj) . "' supplied.");
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