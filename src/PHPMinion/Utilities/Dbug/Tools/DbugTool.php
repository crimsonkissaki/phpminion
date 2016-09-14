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

namespace PHPMinion\Utilities\Dbug\Tools;

use PHPMinion\Utilities\Core\Common;
use PHPMinion\Utilities\Dbug\Dbug;
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;
use PHPMinion\Utilities\Dbug\Models\TraceModel;
use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

/**
 * Class DbugTool
 *
 * Parent class for all DbugTools
 *
 * @created     October 15, 2015
 * @version     0.1
 */
abstract class DbugTool implements DbugToolInterface
{

    /**
     * Dbug instance
     *
     * @var Dbug
     */
    protected $debug;

    /**
     * Common utility class
     *
     * @var Common
     */
    protected $common;

    /**
     * DbugTool rendering Crumb object
     *
     * @var mixed
     */
    protected $crumb;

    /**
     * Alias used to reference the DbugTool object
     *
     * @var string
     */
    protected $toolAlias;

    /**
     * Default message to display if die()
     *
     * Override in child DbugTool if desired
     *
     * @var string
     */
    protected $dieMessage = "<br>Killed by PHPMinion::Dbug<br>";

    /**
     * @param DbugCrumbInterface $crumb
     */
    public function setCrumb(DbugCrumbInterface $crumb)
    {
        $this->crumb = $crumb;
    }

    public function getCrumb()
    {
        return $this->crumb;
    }

    public function getToolAlias()
    {
        return $this->toolAlias;
    }

    /**
     * @param string    $toolAlias
     * @param Dbug|null $debug
     */
    public function __construct($toolAlias, Dbug $debug = null)
    {
        $this->toolAlias = $toolAlias;
        $this->debug = $debug;
        $this->common = new Common();
    }

    /**
     * @inheritDoc
     * @throws DbugException
     */
    public function analyze(array $args = null)
    {
        throw new DbugException(get_class($this) . ' must override DbugTool\'s analyze() method.');
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
     * Gets a string with data for the method where the DbugTool was called
     *
     * @param  TraceModel $trace
     * @return string
     */
    protected function getMethodInfoString(TraceModel $trace)
    {
        $str = (!is_null($trace->class)) ? $trace->class . '->' : '';
        $str .= $trace->function . '() :: ' . $trace->line;

        return $str;
    }


}