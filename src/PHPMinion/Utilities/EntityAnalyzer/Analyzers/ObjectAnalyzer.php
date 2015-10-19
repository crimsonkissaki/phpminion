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
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

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
class ObjectAnalyzer implements AnalyzerInterface
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
    public function analyze($object)
    {
        $this->validateObj($object);

        return $this->_objWorker->analyze($object);
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