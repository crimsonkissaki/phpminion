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
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Translators\DataTypeModelTranslator;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

use PHPMinion\Utilities\ClassAnalyzer\PropertyAnalysis\PropertyAnalysis;

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
        $properties = $this->getDataTypeModelsForObjectProperties($model, $entity);

        echo __METHOD__ . " :: " . __LINE__ . "<BR>";
        echo "properties obtained from analyzing object properties:<BR>";
        // this works
        //var_dump($properties);
        echo "<BR><BR>";

        $model->setValue($properties);

        echo "object model after setting properties:<BR>";
        var_dump($model);
        echo "<BR><BR>";

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
     * @param object      $entity
     * @return DataTypeModel[]
     */
    private function getDataTypeModelsForObjectProperties($entity)
    {
        // good
        $propertyAnalysis = new PropertyAnalysis();

        // dies here - out of mem
        $propertyModels = $propertyAnalysis->analyze($entity, new \ReflectionClass($entity));

        echo __METHOD__ . " :: " . __LINE__ . "<BR>";
        echo "class properties from ClassAnalyzer\PropertyAnalysis:<BR>";
        // works fine
        var_dump($propertyModels);
        echo "<BR><BR>";

        // TODO: This needs to create a property model so i don't muck up the array/object/scalar models with info they don't need
        $dataTypeModels = DataTypeModelTranslator::translateFromClassAnalyzerPropertyModel($propertyModels);

        echo __METHOD__ . " :: " . __LINE__ . "<BR>";
        echo "data type models from the translator:<BR>";
        var_dump($dataTypeModels);
        echo "<BR><BR>";
        die();

        return $dataTypeModels;
    }

}