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
 * Class ObjectModel
 *
 * Model to hold object data
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
class ObjectModel extends DataTypeModel implements DataModelInterface
{

    /**
     * Class represented by the ObjectModel
     *
     * @var string
     */
    private $_className;

    /**
     * @inheritDoc
     *
     * OVERLOADED METHOD
     *
     * Non-array $value args are added as a numeric index
     * ['key' => 'value'] args are added sequentially as provided
     * 'value' should ALWAYS be a DataTypeModel with a set visibility
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->validateValue($value);

        $vals = (is_array($value)) ? $value : [$value];
        foreach ($vals as $property => $dataModel) {
            if (!$dataModel instanceof DataTypeModel) {
                \application\Utils::dbugTrace("fatal error in ObjectModel->setValue()");
                throw new EntityAnalyzerException("ObjectModel values must be DataTypeModels: '" . gettype($dataModel) . "' provided.");
            }
            $vis = $dataModel->getVisibility();
            if (!is_array($this->_value[$vis])) {
                $this->_value[$vis] = [];
            }

            $this->_value[$vis][$property] = $dataModel;
        }
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->_className;
    }

    public function __construct($entity)
    {
        parent::__construct($entity);
        $this->_className = get_class($entity);
    }

    /**
     * Validates the value argument is good
     *
     * @param  mixed $value
     * @return bool
     * @throws EntityAnalyzerException
     */
    private function validateValue($value)
    {
        $args = func_get_args();
        $count = count($args);
        if ($count > 1) {
            throw new EntityAnalyzerException("ObjectModel->setValue() only accepts one argument: '{$count}' provided.");
        }
        if (!is_array($value) && !$value instanceof DataTypeModel) {
            throw new EntityAnalyzerException("ObjectModel->setValue() only accepts DataTypeModels as non-array arguments: '" . gettype($value) . "' provided.");
        }
        // individual value type checks are done in the assignment phase

        return true;
    }

}