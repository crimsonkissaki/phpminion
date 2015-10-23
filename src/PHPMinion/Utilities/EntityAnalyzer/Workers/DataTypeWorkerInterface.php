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

use PHPMinion\Utilities\EntityAnalyzer\Models\DataTypeModel;

/**
 * Class DataTypeWorkerInterface
 *
 * @created     October 22, 2015
 * @version     0.1
 */
interface DataTypeWorkerInterface
{

    /**
     * Converts a PHP entity into the appropriate data type model
     *
     * @param  mixed $entity
     * @return DataTypeModel
     */
    public function createModel($entity);

}