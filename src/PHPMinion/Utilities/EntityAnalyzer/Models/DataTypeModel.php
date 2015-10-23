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

use PHPMinion\Utilities\EntityAnalyzer\Renderers\DataTypeModelRenderer;

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

    /**
     * Renderer type to use the data type
     *
     * @var string
     */
    private $_rendererType;

    /**
     * @return string
     */
    public function getDataType()
    {
        return $this->_dataType;
    }

    /**
     * @param string $dataType
     */
    public function setDataType($dataType)
    {
        $this->_dataType = $dataType;
    }

    /**
     * @return string
     */
    public function getRendererType()
    {
        return $this->_rendererType;
    }

    /**
     * @param string $rendererType
     */
    public function setRendererType($rendererType)
    {
        $this->_rendererType = $rendererType;
    }

}