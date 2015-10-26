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

use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\ClassAnalyzer\PropertyAnalysis\PropertyAnalysis;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * Class ObjectWorker
 *
 * Builds up the ObjectModel data
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectWorker implements DataTypeWorkerInterface
{

    /**
     * @inheritDoc
     */
    public function createModel($entity)
    {
        $this->validateTargetObj($entity);

        $model = new ObjectModel($entity);
        $this->analyzeObjectProperties($model, $entity);

        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $obj
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateTargetObj($obj)
    {
        if (is_object($obj)) {
            return true;
        }
        if (is_string($obj) && class_exists($obj)) {
            return true;
        }

        throw new EntityAnalyzerException("ObjectWorker only accept objects or fully qualified class names: '" . gettype($obj) . "' supplied.");
    }

    /**
     * Creates appropriate DataTypeModels for each object property
     *
     * This is supposed to be a simplistic analysis
     *
     * @param ObjectModel $model
     * @param object      $entity
     */
    private function analyzeObjectProperties(ObjectModel $model, $entity)
    {
        $propertyAnalysis = new PropertyAnalysis();
        $properties = $propertyAnalysis->analyze($entity, new \ReflectionClass($entity));
        // get all object properties, regardless of visibility

        echo "\n\nclass properties from ObjectWorker:\n";
        var_dump($properties);
        die();
    }

}