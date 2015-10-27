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

namespace PHPMinion\Utilities\EntityAnalyzer\Workers;

use PHPMinion\Utilities\Core\Common;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\EntityAnalyzer;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * ArrayWorker
 *
 * Builds up the ArrayModel data
 *
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayWorker implements DataTypeWorkerInterface
{

    /**
     * @param array $entity
     * @return ArrayModel
     */
    public function createModel($entity)
    {
        $this->validateTargetArr($entity);

        $model = new ArrayModel($entity);

        foreach ($entity as $key => $value) {
            $analyzedValue = $this->analyzeArrayValue($value);
            $model->setValue($key, $analyzedValue);
        }

        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $entity
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateTargetArr($entity)
    {
        if (is_array($entity)) {
            return true;
        }

        throw new EntityAnalyzerException("ArrayWorker only accepts arrays: '" . gettype($entity) . "' supplied.");
    }

    /**
     * Generates a DataTypeModel for the array value
     *
     * @param  mixed $value
     * @return DataTypeModel
     */
    private function analyzeArrayValue($value)
    {
        return EntityAnalyzer::analyze($value);
    }

}