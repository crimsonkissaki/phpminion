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

namespace PHPMinion\Utilities\Debug\Tools;

use PHPMinion\Utilities\Core\Common;
use PHPMinion\Utilities\Debug\Debug;
use PHPMinion\Utilities\Debug\Crumbs\DebugCrumbInterface;

abstract class DebugTool
{

    /**
     * Debug instance
     *
     * @var Debug
     */
    protected $debug;

    /**
     * Common utility class
     *
     * @var Common
     */
    protected $common;

    /**
     * DebugTool rendering Crumb object
     *
     * @var mixed
     */
    protected $crumb;

    /**
     * @param DebugCrumbInterface $crumb
     */
    public function setCrumb(DebugCrumbInterface $crumb)
    {
        $this->crumb = $crumb;
    }

    public function getCrumb()
    {
        return $this->crumb;
    }

    /**
     * @param Debug|null $debug
     */
    public function __construct(Debug $debug = null)
    {
        $this->debug = $debug;
        $this->common = new Common();
    }

    /**
     * Returns a simple value for a variable
     *
     * For arrays it returns their length
     * Ignores objects
     *
     * @param   mixed $var
     * @return  int|string
     */
    protected function getSimpleTypeValue($var)
    {
        switch (true) {
            case ($var === false):
                return 'FALSE';
            case ($var === true):
                return 'TRUE';
            case ($var === null):
                return 'NULL';
            case (is_numeric($var)):
                return $var . ' (' . strtoupper(gettype($var)) . ')';
            case (is_string($var)):
                return "'{$var}'";
            case (is_array($var)):
                return 'ARRAY (' . count($var) . ')';
            case (is_object($var)):
                return 'OBJECT (' . get_class($var) . ')';
            default:
                return 'UNKNOWN VAR TYPE';
        }
    }

    /**
     * Returns a full value for a variable
     *
     * Ignores objects
     *
     * @param $var
     * @return string
     */
    protected function getFullSimpleTypeValue($var)
    {
        switch (true) {
            case (is_array($var)):
                ob_start();
                print_r($var);
                return ob_get_clean();
            case (is_object($var)):
                return "full object data not available yet";
            default:
                return $this->getSimpleTypeValue($var);
        }
    }

    /**
     * Gets a string with data for the method DebugTool was called
     *
     * @param  array $methodData
     * @return string
     */
    protected function getMethodInfoString($methodData)
    {
        $str = (!is_null($methodData['class'])) ? $methodData['class'] . '->' : '';
        $str .= $methodData['func'] . '() :: ' . $methodData['line'];

        return $str;
    }


}