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
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\AnalyzerException;

/**
 * ScalarWorker
 *
 * Builds up the ScalarModel data
 *
 * @created     October 18, 2015
 * @version     0.1
 */
class ScalarWorker
{

    /**
     * @param array $array
     * @return EntityModel
     */
    public function workEntity($model, $entity)
    {
        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $array
     * @return bool
     * @throws AnalyzerException
     */
    private function validateTargetEntity($array)
    {
        \PHPMinion\Utilities\Dbug\Dbug::color('validating target array:', 'blue')->ignore()->dump();

        if (is_array($array)) {
            return true;
        }

        throw new AnalyzerException("ScalarWorker only accepts arrays: '" . gettype($array) . "' supplied.");
    }

}