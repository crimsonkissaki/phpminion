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
use PHPMinion\Utilities\EntityAnalyzer\Models\SimpleModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class SimpleAnalyzer
 *
 * Analyzes simple data types and returns the results in a SimpleModel
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class SimpleAnalyzer implements EntityAnalyzerInterface
{

    /**
     * @inheritDoc
     */
    public function analyze($simple)
    {
        \PHPMinion\Utilities\Dbug\Dbug::type($simple, "simple analyzer param type:")->ignore()->dump();

        $this->validateArray($simple);
        $model = $this->_arrayWorker->workArray($simple);

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