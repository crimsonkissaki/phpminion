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

use PHPMinion\Utilities\EntityAnalyzer\Workers\ObjectWorker;
use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;
use PHPMinion\Utilities\EntityAnalyzer\Models\ObjectModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * Class ObjectAnalyzer
 *
 * Analyzes objects and returns the results in an ObjectModel
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectAnalyzer implements EntityAnalyzerInterface
{

    /**
     * @inheritDoc
     */
    public function analyze($entity)
    {
        $this->validateObj($entity);
        $model = new ObjectModel();

        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $entity
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateObj($entity)
    {
        if (is_object($entity)) {
            return true;
        }
        if (is_string($entity) && class_exists($entity)) {
            return true;
        }

        throw new EntityAnalyzerException("ObjectEntityAnalyzer only accept objects or fully qualified class names: '" . gettype($entity) . "' supplied.");
    }

}