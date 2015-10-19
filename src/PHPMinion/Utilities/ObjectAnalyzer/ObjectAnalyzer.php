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

namespace PHPMinion\Utilities\ObjectAnalyzer;

use PHPMinion\Utilities\ObjectAnalyzer\Workers\ObjectWorker;
use PHPMinion\Utilities\ObjectAnalyzer\Exceptions\ObjectAnalyzerException;

/**
 * Class ObjectAnalyzer
 *
 * Analyzes objects and returns a simpler, less memory intensive
 * version of the object and its data for debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectAnalyzer implements ObjectAnalysisInterface
{

    /**
     * @var ObjectWorker
     */
    private $_objWorker;

    public function __construct()
    {
        $this->_objWorker = new ObjectWorker();
    }

    /**
     * @inheritDoc
     */
    public function analyzeObject($obj)
    {
        $this->validateObj($obj);

        return $this->_objWorker->analyze($obj);
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $obj
     * @return bool
     * @throws ObjectAnalyzerException
     */
    private function validateObj($obj)
    {
        if (is_object($obj)) {
            return true;
        }
        if (is_string($obj) && class_exists($obj)) {
            return true;
        }

        throw new ObjectAnalyzerException("ObjectAnalyzer only accept objects or fully qualified class names: '" . gettype($obj) . "' supplied.");
    }

}