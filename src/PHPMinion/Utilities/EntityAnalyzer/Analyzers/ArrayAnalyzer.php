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

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ArrayWorker;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class ArrayAnalyzer
 *
 * Analyzes arrays and returns the results in an ArrayModel
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayAnalyzer implements EntityAnalyzerInterface
{

    /**
     * @var ArrayWorker
     */
    private $_arrayWorker;

    public function __construct()
    {
        $this->_arrayWorker = new ArrayWorker();
    }

    /**
     * @inheritDoc
     */
    public function analyze($array)
    {
        \PHPMinion\Utilities\Dbug\Dbug::type($array, "array analyzer param type:")->ignore()->dump();

        $this->validateArray($array);
        $model = $this->_arrayWorker->workArray($array);

        return $model;
    }

    public function render(DataTypeModel $model)
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

        throw new AnalyzerException("ArrayEntityAnalyzer only accept arrays: '" . gettype($obj) . "' supplied.");
    }

}