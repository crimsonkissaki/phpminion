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
    public function analyze($entity)
    {
        $this->validateDataType($entity);

        $model = new SimpleModel();

        return $model;
    }

    /**
     * Verifies the analysis target entity is workable
     *
     * @param  mixed $entity
     * @return bool
     * @throws AnalyzerException
     */
    private function validateDataType($entity)
    {
        if (!is_bool($entity) && !is_numeric($entity) && !is_string($entity) && !is_null($entity)) {
            throw new AnalyzerException("ArrayEntityAnalyzer only accept arrays: '" . gettype($entity) . "' supplied.");
        }

        return true;
    }

}