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
use PHPMinion\Utilities\Dbug\Tools\DbugTool;
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

    public function getTools()
    {
        return $this->_tools;
    }

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
        $this->registerTool('dbug', $toolPath.'\DbugDump')
            ->registerTool('trace', $toolPath.'\DbugTrace')
            ->registerTool('color', $toolPath.'\DbugColor')
            ->registerTool('textarea', $toolPath.'\DbugTextarea')
            //->registerTool('type', $toolPath.'\DbugType')
        ;
    }

    public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Dbug();
        }

        return self::$_instance;
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
     * Static accessibility mutator
     *
     * @param string $name
     * @param array  $args
     * @return DbugToolInterface
     */
    public static function __callStatic($name, $args)
    {
        $dbug = self::getInstance();
        $dbug->validateCalledTool($name);
        /** @var DbugToolInterface $tool */
        $tool = $dbug->getDbugTool($name);
        $tool->analyze($args);
        $dbug->_dbugStack[] = $tool->getDbugResults();

        return $dbug;
    }

    /**
     * Registers a tool with Dbug
     *
     * TODO: allow tool registration with arrays?
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
     * Removes & outputs last executed DbugTool results from the stack
     *
     * @return Dbug
     */
    public function only()
    {
        echo array_pop($this->_dbugStack);

        return $this;
    }

    /**
     * Outputs the DbugTool results without terminating the script
     *
     * @param int $count How far back along the stack to dump.
     *                   If $count > stack count it will fail silently
     *                   after dumping any available results.
     * @return Dbug
     */
    public function dump($count = 1)
    {
        $total = count($this->_dbugStack) - 1;
        for ($i=0; $i<=$count; $i+=1) {
            $next = $total - $i;
            if (empty($this->_dbugStack[$next])) {
                break;
            }
            echo $this->_dbugStack[$next];
        }

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
     * @throws DbugException
     */
    private function validateCalledTool($name)
    {
        if (!isset($this->_tools[$name])) {
            throw new DbugException("'{$name}' is not a registered DbugTool.");
        }
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
