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
     * Gets details of method that called a Util method
     *
     * Can be accessed statically via _getMethodInfo()
     *
     * @param int $level    Where the calling method's info is in debug_backtrace()
     *                      Default is 4 since this will likely be called from
     *                      inside a Utils method.
     * @return TraceModel
     */
    public function getMethodInfo($level = 4)
    {
        $trace = debug_backtrace();

        // TODO: modify level if accessing this via Common's static bypass?
        if ($trace[$level]['type'] === '::') {
            //$level += 1;
        }

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
        */

        $model = new TraceModel();
        $tl = $trace[$level + 1];
        $model->function = (!empty($tl['function'])) ? $tl['function'] : null;

        $tl = $trace[$level];
        $model->class = (!empty($tl['class'])) ? $this->getRelativeFilePath($tl['class']) : null;
        $model->object = (!empty($tl['object'])) ? $tl['object'] : null;
        $model->args = (!empty($tl['args'])) ? $tl['args'] : null;

        $tl = $trace[$level - 1];
        $model->file = (!empty($tl['file'])) ? $this->getRelativeFilePath($tl['file']) : null;
        $model->line = (!empty($tl['line'])) ? $tl['line'] : null;

        /*
        echo "Model:<br>";
        var_dump($model);
        echo "<br><hr><br>";
        die();
        */

        return $model;
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
                return __METHOD__ . ' cannot handle objects yet.';
            default:
                return $this->getSimpleTypeValue($var);
        }
    }

}