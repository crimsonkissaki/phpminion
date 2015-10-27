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

namespace PHPMinion\Utilities\EntityAnalyzer\Models;

use PHPMinion\Utilities\EntityAnalyzer\Exceptions\EntityAnalyzerException;

/**
 * Class ArrayModel
 *
 * Model to hold array data
 *
 * @created     October 18, 2015
 * @version     0.1
 */
class ArrayModel extends DataTypeModel implements DataModelInterface
{

    /**
     * @inheritDoc
     *
     * OVERLOADED METHOD
     *
     * Non-array $value args are added as a numeric index
     * ['key' => 'value'] args are added sequentially as provided
     *
     * @param  mixed $value
     * @throws EntityAnalyzerException
     */
    public function setValue($value)
    {
        $vals = (is_array($value)) ? $value : [$value];
        foreach ($vals as $key => $val) {
            $this->_value[$key] = $val;
        }
    }

    /**
     * @param  mixed $key
     * @return mixed
     * @throws EntityAnalyzerException
     */
    public function getValueByKey($key)
    {
        if (isset($this->_value[$key])) {
            return $this->_value[$key];
        }

        throw new EntityAnalyzerException("No array element exists for key '{$key}'.");
    }

}