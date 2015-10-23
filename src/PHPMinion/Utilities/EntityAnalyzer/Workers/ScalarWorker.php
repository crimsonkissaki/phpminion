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

use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * ScalarWorker
 *
 * Converts scalar data types into a ScalarModel
 *
 * Int, Float, Bool, String, Null
 *
 * @created     October 22, 2015
 * @version     0.1
 */
class ScalarWorker implements DataTypeWorkerInterface
{

    /**
     * @inheritDoc
     */
    public function createModel($entity)
    {
        $this->validateTargetEntity($entity);

        $model = new ScalarModel();
        $model->setDataType(strtolower(gettype($entity)));
        $model->setRendererType('scalar');
        $model->setValue($entity);

        return $model;
    }

    /**
     * Verifies the target entity is workable
     *
     * @param  mixed $entity
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateTargetEntity($entity)
    {
        if (is_bool($entity) || is_string($entity) || is_null($entity) || is_numeric($entity)) {
            return true;
        }

        throw new EntityAnalyzerException("ScalarWorker only accepts scalar values: '" . gettype($entity) . "' supplied.");
    }

}