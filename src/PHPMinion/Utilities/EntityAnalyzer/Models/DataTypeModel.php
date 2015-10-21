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

/**
 * Class DataTypeModel
 *
 * Parent model for all EntityEntityAnalyzer models
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 18, 2015
 * @version     0.1
 */
abstract class DataTypeModel
{

    /**
     * Data type the model represents
     *
     * @var string
     */
    private $_dataType;

    public function getDataType()
    {
        return $this->_dataType;
    }

    public function setDataType($dataType)
    {
        $this->_dataType = $dataType;
    }

}