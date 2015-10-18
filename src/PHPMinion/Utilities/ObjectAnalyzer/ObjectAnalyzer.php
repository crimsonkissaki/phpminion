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
     * @inheritDoc
     */
    public function analyzeObject($obj)
    {
        ob_start();
        var_dump($obj);
        $data = ob_get_clean();

        return $data;
    }

}