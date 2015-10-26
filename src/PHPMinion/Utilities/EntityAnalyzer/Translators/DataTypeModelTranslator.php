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

namespace PHPMinion\Utilities\EntityAnalyzer\Translators;

use PHPMinion\Utilities\EntityAnalyzer\Factories\WorkerFactory;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;

/**
 * Class DataTypeModelTranslator
 *
 * This class handles translating results from other libraries into something
 * EntityAnalyzer can use (DataTypeModels)
 */
class DataTypeModelTranslator
{

    /**
     * Converts PHPMinion\Utilities\ClassAnalyzer PropertyModel(s) into
     * EntityAnalyzer DataTypeModel(s)
     *
     * @param  mixed $foreignData
     * @return DataTypeModel[]
     */
    public static function translateFromClassAnalyzerPropertyModel($foreignData)
    {
        /** @var \PHPMinion\Utilities\ClassAnalyzer\Models\PropertyModel[] $models */
        $models = (is_array($foreignData)) ? $foreignData : array($foreignData);
        $localData = [];
        $factory = WorkerFactory::getInstance();
        foreach ($models as $model) {
            $valueData = $model->getCurrentValue();
            $worker = $factory->getWorker($valueData);
            $localModel = $worker->createModel($valueData);
            $localModel->setVisibility($model->getVisibility());
            $localData[$model->getName()] = $localModel;
        }

        return $localData;
    }

}