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

use PHPMinion\Utilities\EntityAnalyzer\Models\ArrayModel;
use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * ArrayWorker
 *
 * Builds up the ArrayModel data
 *
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayWorker
{

    /**
     * @param array $array
     * @return EntityModel
     */
    public function workArray(array $array)
    {
        \PHPMinion\Utilities\Dbug\Dbug::dbug($array, "array worker array vals:")->ignore()->dump();

        $this->validateTargetArr($array);

        \PHPMinion\Utilities\Dbug\Dbug::color('target array validated!', 'purple')->ignore()->dump();

        $model = new ArrayModel();

        \PHPMinion\Utils::dbug($model, "model in work array");

        foreach ($array as $key => $value) {
            $model->elements[$key] = $value;
        }

        \PHPMinion\Utils::dbug($model, "model being returned from workArray");
        return $model;
    }

    /**
     * Verifies the analysis target is workable
     *
     * @param  mixed $array
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateTargetArr($array)
    {
        \PHPMinion\Utilities\Dbug\Dbug::color('validating target array:', 'blue')->ignore()->dump();

        if (is_array($array)) {
            return true;
        }

        throw new EntityAnalyzerException("ArrayWorker only accepts arrays: '" . gettype($array) . "' supplied.");
    }

}