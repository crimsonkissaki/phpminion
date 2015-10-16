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

namespace PHPMinion\Utilities\Debug;

use PHPMinion\Utilities\Debug\Tools\DebugToolInterface;
use PHPMinion\Utilities\Debug\Exceptions\DebugException;

/**
 * Class Debug
 *
 * Making debugging a bit simpler
 *
 * @package PHPMinion\Utilities
 */
class Debug
{

    /**
     * Registered Debug Tools
     *
     * @var array
     */
    private $_tools = [];

    /**
     * Registered Debug output crumbs
     *
     * @var array
     */
    private $_crumbs = [];

    /**
     * Stack of Debug outputs
     *
     * @var array
     */
    private $_debugStack = [];

    /**
     * @var Debug
     */
    private static $_instance;

    /**
     * Initial setup registers default tools
     */
    private function __construct()
    {
        $this->registerTool('dbug', '\PHPMinion\Utilities\Debug\Tools\DebugDump')
            ->registerTool('trace', '\PHPMinion\Utilities\Debug\Tools\DebugTrace')
            ->registerTool('color', '\PHPMinion\Utilities\Debug\Tools\DebugColor')
            ->registerTool('textarea', '\PHPMinion\Utilities\Debug\Tools\DebugTextarea')
            ->registerTool('type', '\PHPMinion\Utilities\Debug\Tools\DebugType');

        $this->registerCrumb('dbug', '\PHPMinion\Utilities\Debug\Crumbs\DebugDumpCrumb');

    }

    public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Debug();
        }

        return self::$_instance;
    }

    /**
     * Registers a tool with Debug
     *
     * TODO: allow tool registration with arrays?
     *
     * @param string $alias   Alias to call the DebugTool via static Debug:: calls
     * @param string $class   Class to handle debug work
     * @param bool   $replace Allow replacing of a previously declared aliased tool?
     * @return Debug
     * @throws DebugException
     */
    public function registerTool($alias, $class, $replace = false)
    {
        if (!$this->validateAlias($alias)) {
            throw new DebugException("Unable to register a Debug Tool without an alias.");
        }

        if (isset($this->_tools[$alias]) && !$replace) {
            throw new DebugException("A Debug Tool with alias '{$alias}' is already registered.");
        }

        if (!$this->validateClass($class)) {
            throw new DebugException("Unable to register a Debug Tool without a valid Tool class.");
        }

        $this->_tools[$alias] = $class;

        return $this;
    }

    /**
     * Registers a Crumb for rendering a DebugTool result
     *
     * TODO: allow crumb registration with arrays?
     *
     * @param string $toolAlias Previously declared DebugTool alias that will use the Crumb
     * @param string $class     Class to handle Debug Tool output generation
     * @param bool   $replace   Allow replacing of a previously declared DebugTool Crumb?
     * @return Debug
     * @throws DebugException
     */
    public function registerCrumb($toolAlias, $class, $replace = false)
    {
        if (!$this->validateAlias($toolAlias)) {
            throw new DebugException("Unable to register a Tool Crumb without an alias.");
        }

        if (isset($this->_crumbs[$toolAlias]) && !$replace) {
            throw new DebugException("A Tool Crumb has already been registered for a Debug Tool with alias '{$toolAlias}'.");
        }

        if (!$this->validateClass($class)) {
            throw new DebugException("Unable to register a Tool Crumb without a valid Crumb class.");
        }

        $this->_crumbs[$toolAlias] = $class;

        return $this;
    }

    /**
     * Static accessibility mutator
     *
     * @param string $name
     * @param array  $args
     * @return DebugToolInterface
     * @throws DebugException
     */
    public static function __callStatic($name, $args)
    {
        $debug = self::getInstance();

        /*
        echo "calling __callStatic for method '{$name}'<BR>";
        echo "using args:<BR>";
        var_dump($args);

        echo "<BR><BR>";
        echo "debug obj:<BR>";
        var_dump($debug);

        echo "<BR><BR><HR><BR><BR>";
        */

        if (!isset($debug->_tools[$name])) {
            throw new DebugException("'{$name}' is not a registered DebugTool.");
        }

        if (!isset($debug->_crumbs[$name])) {
            throw new DebugException("'{$name}' is not a registered DebugTool Crumb.");
        }

        $crumb = new $debug->_crumbs[$name];
        $crumb->toolAlias = $name;

        $tool = new $debug->_tools[$name]($debug);
        $tool->setCrumb($crumb);

        /*
        echo "tool:<BR>";
        var_dump($tool);
        echo "<HR>";
        die();
        */

        $debug->_debugStack[] = $tool->analyze($args)->getCrumb()->render();

        return $tool;
    }

    /**
     * Kills the script
     *
     * @param string $dieMsg
     */
    public function kill($dieMsg)
    {
        foreach ($this->_debugStack as $dbug) {
            echo $dbug;
        }

        die($dieMsg);
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




}
