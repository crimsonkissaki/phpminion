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

use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class EntityAnalyzer
 *
 * Analyzes objects and returns a simpler, less memory intensive
 * version of the object and its data for debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayAnalyzer implements AnalyzerInterface
{

    public function __construct()
    {
    }

    /**
     * @inheritDoc
     */
    public function analyze($array)
    {
        $this->validateArray($array);
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $obj
     * @return bool
     * @throws AnalyzerException
     */
    private function validateArray($obj)
    {
        if (is_array($obj)) {
            return true;
        }

        throw new AnalyzerException("ArrayAnalyzer only accept arrays: '" . gettype($obj) . "' supplied.");
    }

}