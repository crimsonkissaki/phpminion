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

namespace PHPMinion\Utilities\EntityAnalyzer\Analyzers;

use PHPMinion\Utilities\EntityAnalyzer\Workers\ObjectWorker;
use PHPMinion\Utilities\EntityAnalyzer\Models\EntityModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class ObjectAnalyzer
 *
 * Analyzes objects and returns the results in an ObjectModel
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectAnalyzer implements AnalyzerInterface
{

    /**
     * @var ObjectWorker
     */
    private $_objWorker;

    /**
     * @var EntityModel
    private $_objectModel;
     */

    public function __construct()
    {
        $this->_objWorker = new ObjectWorker();
    }

    /**
     * @inheritDoc
     */
    public function analyze($object)
    {
        $this->validateObj($object);
        //$this->_objectModel = $this->_objWorker->analyze($object);
        $model = $this->_objWorker->workObject($object);

        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $obj
     * @return bool
     * @throws AnalyzerException
     */
    private function validateObj($obj)
    {
        if (is_object($obj)) {
            return true;
        }
        if (is_string($obj) && class_exists($obj)) {
            return true;
        }

        throw new AnalyzerException("ObjectAnalyzer only accept objects or fully qualified class names: '" . gettype($obj) . "' supplied.");
    }

}