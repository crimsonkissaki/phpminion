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
 * Class ObjectAnalysisInterface
 *
 * Interface for any class used by DbugTools to get
 * object information for debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
interface ObjectAnalysisInterface
{

    /**
     * Analyzes objects and returns a simplified summary
     *
     * @param  object $obj Object to analyze
     * @return mixed
     */
    public function analyzeObject($obj);

}