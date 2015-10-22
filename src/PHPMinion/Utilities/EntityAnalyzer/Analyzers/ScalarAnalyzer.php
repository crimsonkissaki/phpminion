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
use PHPMinion\Utilities\EntityAnalyzer\Models\ScalarModel;
use PHPMinion\Utilities\EntityAnalyzer\Workers\ScalarWorker;
use PHPMinion\Utilities\EntityAnalyzer\Factories\WorkerFactory;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * Class ScalarAnalyzer
 *
 * Analyzes simple data types and returns the results in a ScalarModel
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ScalarAnalyzer implements EntityAnalyzerInterface
{

    /**
     * @inheritDoc
     */
    public function analyze($entity)
    {
        $this->validateDataType($entity);

        $model = new ScalarModel();
        $worker = WorkerFactory::getInstance()->getWorker($entity);
        $worker->workEntity($entity);


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