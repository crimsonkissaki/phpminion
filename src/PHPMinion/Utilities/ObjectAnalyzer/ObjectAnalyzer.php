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
        if (is_object($obj)) {
            $refObj = new \ReflectionObject($obj);
        }
        if (is_string($obj)) {
            $refObj = new \ReflectionClass($obj);
        }

        $this->_objWorker->setObject($obj);
        $this->_objWorker->setReflectionObject($refObj);
        $_obj = $this->_objWorker->analyze();

        ob_start();
        var_dump($_obj);
        $data = ob_get_clean();

        return $data;
    }

}