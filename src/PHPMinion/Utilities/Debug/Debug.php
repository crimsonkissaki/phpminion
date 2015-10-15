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

use PHPMinion\PHPMinion;
use PHPMinion\Utilities\Debug\DebugToolInterface;
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
     * Registered dbug tools
     *
     * @var array
     */
    private $_tools = [];

    /**
     * Registered dbug output crumbs
     *
     * @var array
     */
    private $_crumbs = [];

    /**
     * Initial setup registers default tools
     */
    public function __construct()
    {
        $this->registerTool('dbug', '\PHPMinion\Utilities\Debug\Tools\DebugDump')
            ->registerTool('trace', '\PHPMinion\Utilities\Debug\Tools\DebugTrace');

    }

    /**
     * Registers a tool with Debug
     *
     * TODO: allow tool registration with arrays?
     *
     * @param string $alias     Alias to call the DebugTool via static Debug:: calls
     * @param string $class     Class to handle debug work
     * @param bool   $replace   Allow replacing of a previously declared aliased tool?
     * @return Debug
     * @throws DebugException
     */
    public function registerTool($alias, $class, $replace = false)
    {
        if (!is_string($alias) || empty($alias)) {
            throw new DebugException("Unable to register a Debug Tool without an alias.");
        }

        if (isset($this->_tools[$alias]) && !$replace) {
            throw new DebugException("A Debug Tool with alias '{$alias}' is already registered.");
        }

        if (!is_string($class) || empty($class) || !class_exists($class)) {
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
     * @param string $toolAlias     Previously declared DebugTool alias that will use the Crumb
     * @param string $class         Class to handle Debug Tool output generation
     * @param bool   $replace       Allow replacing of a previously declared DebugTool Crumb?
     * @return Debug
     * @throws DebugException
     */
    public function registerCrumb($toolAlias, $class, $replace = false)
    {
        if (!is_string($toolAlias) || empty($toolAlias)) {
            throw new DebugException("Unable to register a Tool Crumb without an alias.");
        }

        if (isset($this->_crumbs[$toolAlias]) && !$replace) {
            throw new DebugException("A Tool Crumb has already been registered for a Debug Tool with alias '{$toolAlias}'.");
        }

        if (!is_string($class) || empty($class) || !class_exists($class)) {
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
     * @throws DebugException
     */
    public static function __callStatic($name, $args)
    {
        $debug = new Debug();

        echo "calling __callStatic for method '{$name}'<BR>";

        echo "using args:<BR>";

        var_dump($args);

        echo "<BR><BR>";

        echo "debug obj:<BR>";
        var_dump($debug);

        if (!isset($debug->_tools[$name])) {
            throw new DebugException("'{$name}' is not a registered DebugTool.");
        }

        echo "debug tool obj:<BR>";
        $tool = new $debug->_tools[$name];
        $tool->analyze($args);

        var_dump($tool);

        die("<BR><BR>__callStatic()<BR><BR>");

    }

}
