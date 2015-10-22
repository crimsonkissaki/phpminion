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

use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

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
     * @inheritDoc
     */
    public function analyze($entity)
    {
        $this->validateArray($entity);

        $model = new ArrayModel();

        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $entity
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateArray($entity)
    {
        if (!is_array($entity)) {
            throw new EntityAnalyzerException("ArrayEntityAnalyzer only accept arrays: '" . gettype($entity) . "' supplied.");
        }

        return true;
    }

}