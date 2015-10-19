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

namespace PHPMinion\Utilities\Core;

use PHPMinion\PHPMinion;
use PHPMinion\Utilities\Core\Exceptions\PHPMinionException;
use PHPMinion\Utilities\Dbug\Dbug;
use PHPMinion\Utilities\Dbug\Models\TraceModel;

/**
 * Class Common
 *
 * Methods used throughout PHPMinion
 *
 * @created     October 14, 2015
 * @version     0.1
 */
class Common
{

    /**
     * Default debug_backtrace() index to start with
     * to get accurate trace results
     */
    const DEFAULT_STARTING_BACKTRACE_INDEX = 4;

    /**
     * Static accessor for Common class
     *
     * @param string $name
     * @param string $args
     * @return mixed
     * @throws PHPMinionException
     */
    public static function __callStatic($name, $args)
    {
        $_this = new Common();
        $method = substr($name, 1);
        if (!method_exists($_this, $method)) {
            throw new PHPMinionException("ERROR: Class 'Common' has no '{$method}' method.");
        }

        return call_user_func_array(array($_this, $method), $args);
    }

    /**
     * Gets a file path relative to project root
     *
     * Can be accessed statically via _getRelativeFilePath()
     *
     * @param  string $path
     * @return string
     */
    public function getRelativeFilePath($path)
    {
        $root = PHPMinion::getInstance()->getConfig('PROJECT_ROOT_PATH');

        return str_replace($root, '', $path);
    }

    /**
     * Returns a string inside a <span> with font-color
     *
     * Can be accessed statically via _colorize()
     *
     * @param string $var
     * @param string $color
     * @return string
     */
    public function colorize($var, $color = '#F00;')
    {
        return "<span style='color: {$color}; text-align: left;'>{$var}</span>";
    }

    /**
     * Gets details of method calling DbugTool method
     *
     * Can be accessed statically via _getMethodInfo()
     *
     * @param int        $level Where the calling method's info is in debug_backtrace()
     *                          Default is 4 since this will likely be called from
     *                          inside a Utils method.
     * @param array|null $trace debug_backtrace() array
     *                          If multiple levels of backtrace info is desired, passing
     *                          in a single debug_backtrace() array will save memory.
     * @return TraceModel
     */
    public function getMethodInfo($level = self::DEFAULT_STARTING_BACKTRACE_INDEX, array $trace = null)
    {
        if (!is_null($trace)) {
            $level -= 1;
        } else {
            $trace = debug_backtrace();
        }

        // TODO: modify level if accessing this via Common's static bypass?
        /*
        if ($trace[$level]['type'] === '::') {
            $level += 1;
        }
        */

        /*
        echo "Trace: " . ($level + 2) . "<br>";
        var_dump($trace[$level + 2]);
        echo "<br><hr><br>";

        echo "Trace: " . ($level + 1) . "<br>";
        var_dump($trace[$level + 1]);
        echo "<br><hr><br>";

        echo "Trace (start): {$level}<br>";
        var_dump($trace[$level]);
        echo "<br><hr><br>";

        echo "Trace: " . ($level - 1) . "<br>";
        var_dump($trace[$level - 1]);
        echo "<br><hr><br>";

        echo "Trace: " . ($level - 2) . "<br>";
        var_dump($trace[$level - 2]);
        echo "<br><hr><br>";

        echo "Trace: " . ($level - 3) . "<br>";
        var_dump($trace[$level - 3]);
        echo "<br><hr><br>";
        die();
        */

        $model = new TraceModel();
        if (!empty($trace[$level])) {
            $tl = $trace[$level];
            $model->function = (!empty($tl['function'])) ? $tl['function'] : null;
            $model->class = (!empty($tl['class'])) ? $this->getRelativeFilePath($tl['class']) : null;
            $model->object = (!empty($tl['object'])) ? $tl['object'] : null;
            $model->args = (!empty($tl['args'])) ? $tl['args'] : null;
        }

        if (!empty($trace[$level - 1])) {
            $tl = $trace[$level - 1];
            $model->file = (!empty($tl['file'])) ? $this->getRelativeFilePath($tl['file']) : null;
            $model->line = (!empty($tl['line'])) ? $tl['line'] : null;
        }

        return $model;
    }

    /**
     * Gets a string with data for the method where the DbugTool was called
     *
     * @param  TraceModel $trace
     * @return string
     */
    public function getMethodInfoString(TraceModel $trace)
    {
        $str = '';
        if (!is_null($trace->class)) {
            $str = $trace->class;
        } elseif (!is_null($trace->file)) {
            $str = $trace->file;
        }
        $str .= (!is_null($trace->function)) ? "->{$trace->function}() " : '';
        $str .= ":: {$trace->line}";

        return $str;
    }

    /**
     * Returns a simple value for a variable
     *
     * @param   mixed $var
     * @return  string
     */
    public function getSimpleTypeValue($var)
    {
        switch (true) {
            case ($var === false):
                return 'BOOLEAN (FALSE)';
            case ($var === true):
                return 'BOOLEAN (TRUE)';
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
     * @param  mixed $var
     * @return string
     */
    public function getFullSimpleTypeValue($var)
    {
        switch (true) {
            case (is_array($var)):
                ob_start();
                print_r($var);
                return ob_get_clean();
            case (is_object($var)):
                $analyzer = Dbug::getInstance()->getConfig()->getEntityAnalyzer();
                $obj = $analyzer->analyze($var);
                ob_start();
                print_r($obj);
                return ob_get_clean();
            default:
                return $this->getSimpleTypeValue($var);
        }
    }

}