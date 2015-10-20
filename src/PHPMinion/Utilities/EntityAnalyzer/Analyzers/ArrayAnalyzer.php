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

use PHPMinion\Utilities\EntityAnalyzer\Models\EntityModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;

/**
 * Class EntityAnalyzer
 *
 * Analyzes arrays and returns the results in an ArrayModel
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayAnalyzer implements AnalyzerInterface
{

    private $_arrayWorker;

    /**
     * @var ArrayModel
     */
    private $_arrayModel;

    public function __construct()
    {
        $this->_arrayWorker = '';
    }

    /**
     * @inheritDoc
     */
    public function analyze($array)
    {
        $this->validateArray($array);
        $this->_arrayModel = new ArrayModel();

        return $this->_arrayModel;
    }

    public function render(EntityModel $model)
    {

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