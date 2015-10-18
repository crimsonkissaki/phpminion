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

namespace PHPMinion\Utilities\Dbug;

use PHPMinion\Utilities\Core\Common;
use PHPMinion\Utilities\Dbug\Tools\DbugToolInterface;
use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

/**
 * Class Dbug
 *
 * Gateway and container for debugging tools/results
 *
 * TODO: configuration options for Dbug
 *  - have output scrollable
 *  - expand/contract dbug statements (folder structure)
 *  - better exception handling
 *
 * @created     October 9, 2015
 * @version     0.1
 */
class Dbug
{

    /**
     * Registered Dbug Tools
     *
     * @var array
     */
    private $_tools = [];

    /**
     * Stack of Dbug outputs
     *
     * @var array
     */
    private $_dbugStack = [];

    /**
     * @var Dbug
     */
    private static $_instance;

    /**
     * Default message shown upon kill()
     *
     * @var string
     */
    private $_dieMsg = '<br>Killed by PHPMinion::Dbug<br>';

    /**
     * Current DbugTool accessed
     *
     * @var DbugToolInterface
     */
    private $_currentTool;

    /**
     * Results from current DbugTool
     * @var string
     */
    private $_currentToolResults;

    /**
     * Config options for current DbugTool
     * @var array
     */
    private $_currentToolConfigs = [];

    /**
     * Prevent current DbugTool results from being added to result stack
     *
     * @var bool
     */
    private $_ignoreCurrent = false;

    /**
     * @return array
     */
    public function getTools()
    {
        return $this->_tools;
    }

    /**
     * @return array
     */
    public function getDbugStack()
    {
        return $this->_dbugStack;
    }

    /**
     * Initial setup registers default DbugTools
     */
    private function __construct()
    {
        $toolPath = '\PHPMinion\Utilities\Dbug\Tools';
        /*
        $this->registerTool('dbug', $toolPath.'\DbugDump')
            ->registerTool('trace', $toolPath.'\DbugTrace')
            ->registerTool('color', $toolPath.'\DbugColor')
            ->registerTool('textarea', $toolPath.'\DbugTextarea')
            ->registerTool('type', $toolPath.'\DbugType')
        ;
        */
        $this->registerTools([
            'dbug' => $toolPath.'\DbugDump',
            'trace' => $toolPath.'\DbugTrace',
            'color' => $toolPath.'\DbugColor',
            'textarea' => $toolPath.'\DbugTextarea',
            'type' => $toolPath.'\DbugType',
        ]);
    }

    /**
     * @return Dbug
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Dbug();
        }

        return self::$_instance;
    }

    /**
     * Static accessibility mutator to access registered DbugTools
     *
     * @param string $alias
     * @param array  $args
     * @return Dbug
     */
    public static function __callStatic($alias, $args)
    {
        $_this = self::getInstance();
        $_this->validateCalledTool($alias);
        $_this->resetInstanceProperties();
        $_this->_currentTool = $_this->getDbugTool($alias);
        $_this->_currentTool->analyze($args);

        return $_this;
    }

    /**
     * Registers multiple tools with Dbug
     *
     * @param array      $tools
     * @param bool|false $replace
     * @return Dbug
     */
    public function registerTools(array $tools, $replace = false)
    {
        foreach ($tools as $alias => $class) {
            $this->registerTool($alias, $class, $replace);
        }

        return $this;
    }

    /**
     * Registers a tool with Dbug
     *
     * @param string $alias   Alias to call the DbugTool via static Dbug:: calls
     * @param string $class   Class to handle debug work
     * @param bool   $replace Allow replacing of a previously declared aliased tool?
     * @return Dbug
     * @throws DbugException
     */
    public function registerTool($alias, $class, $replace = false)
    {
        $this->validateRegisterArgs($alias, $class);
        if (isset($this->_tools[$alias]) && !$replace) {
            throw new DbugException("ERROR: A Dbug Tool with alias '{$alias}' is already registered.");
        }

        $this->_tools[$alias] = new $class($alias);

        return $this;
    }

    /**
     * Returns a previously defined DbugTool
     *
     * @param  string $alias
     * @return DbugToolInterface
     * @throws DbugException
     */
    public static function getTool($alias)
    {
        $_this = self::getInstance();
        if (empty($_this->_tools[$alias])) {
            throw new DbugException("No DbugTool registered under alias '{$alias}'");
        }

        return $_this->getDbugTool($alias);
    }

    /**
     * Current DbugTool results won't be added to _dbugStack
     *
     * @return Dbug
     */
    public function ignore()
    {
        $this->_ignoreCurrent = true;

        return $this;
    }

    /**
     * Sets config options that are passed to the DbugTool's Crumb
     *
     * <code>
     * This is an overloaded method!
     * Accepts:
     *  ($configs[])     : array of param => value settings
     *  ($param, $value) : param and its value
     *  ($param)         : 'flag' param to set to true
     * </code>
     *
     * @param mixed  $configs
     * @return Dbug
     */
    public function config($configs)
    {
        $opts = func_get_args();

        for ($i = 0; $i < count($opts); $i += 1) {
            $cur = $opts[$i];
            if (is_array($cur)) {
                $this->_currentToolConfigs = array_merge($this->_currentToolConfigs, $cur);
            }
            if (is_string($cur)) {
                if (empty($opts[$i + 1])) {
                    $this->_currentToolConfigs[$cur] = true;
                } else {
                    $this->_currentToolConfigs[$cur] = $opts[$i + 1];
                    $i += 1;
                }
            }
        }

        return $this;
    }

    /**
     * Renders the tool results
     *
     * Appends results to result stack if not ignored
     *
     * @return Dbug
     * @throws DbugException
     */
    public function render()
    {
        $this->_currentTool->setConfig($this->_currentToolConfigs);
        if (!$this->_currentToolResults = $this->_currentTool->render()) {
            throw new DbugException("'{$this->_currentTool->getToolAlias()}' did not return valid render results.");
        }
        if (!$this->_ignoreCurrent) {
            $this->_dbugStack[] = $this->_currentToolResults;
        }

        return $this;
    }

    /**
     * Dumps current DbugTool results to the screen
     *
     * Appends results to result stack if not ignored
     *
     * @return Dbug
     */
    public function dump()
    {
        if (is_null($this->_currentToolResults)) {
            $this->render();
        }
        echo $this->_currentToolResults;

        return $this;
    }

    /**
     * Outputs all accumulated DbugTool results
     *
     * @return Dbug
     */
    public function dumpAll()
    {
        foreach ($this->_dbugStack as $dbug) {
            echo $dbug;
        }

        return $this;
    }

    /**
     * Kills Dbug
     *
     * @param string|bool $dieMsg
     */
    public function kill($dieMsg = false)
    {
        $dieMsg = (!$dieMsg) ? $this->_dieMsg : $dieMsg;
        $dieOutput = '<div style="position: relative;">'.Common::_colorize($dieMsg).'</div>';

        die($dieOutput);
    }

    /**
     * Validates register args
     *
     * @param string $alias
     * @param string $class
     * @throws DbugException
     */
    private function validateRegisterArgs($alias, $class)
    {
        if (!$this->validateAlias($alias)) {
            throw new DbugException("Unable to register DbugTool: invalid alias '{$alias}'.");
        }
        if (!$this->validateClass($class)) {
            throw new DbugException("Unable to register DbugTool: invalid class '{$class}'.");
        }
    }

    /**
     * Verifies the alias is a valid string
     *
     * @param  string $alias
     * @return bool
     */
    private function validateAlias($alias)
    {
        return (is_string($alias) && !empty($alias));
    }

    /**
     * Verifies that the class is a valid class
     *
     * @param  string $class
     * @return bool
     */
    private function validateClass($class)
    {
        return (is_string($class) && !empty($class) && class_exists($class));
    }

    /**
     * @param  string $name
     * @return bool
     * @throws DbugException
     */
    private function validateCalledTool($name)
    {
        if (!isset($this->_tools[$name])) {
            throw new DbugException("'{$name}' is not a registered DbugTool.");
        }

        return true;
    }

    /**
     * Resets Dbug properties that are used on a per-tool call basis
     */
    private function resetInstanceProperties()
    {
        $this->_currentTool = null;
        $this->_ignoreCurrent = false;
        $this->_currentToolResults = null;
        $this->_currentToolConfigs = [];
    }

    /**
     * Gets the requested DbugTool object
     *
     * @param  string $name
     * @return DbugToolInterface
     */
    private function getDbugTool($name)
    {
        return $this->_tools[$name];
    }

}
