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
     * Registered Dbug output crumbs
     *
     * @var array
     */
    private $_crumbs = [];

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

    public function getCrumbs()
    {
        return $this->_crumbs;
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
            //->registerTool('trace', $toolPath.'\DbugTrace')
            ->registerTool('color', $toolPath.'\DbugColor')
            //->registerTool('textarea', $toolPath.'\DbugTextarea')
            //->registerTool('type', $toolPath.'\DbugType')
            ;

        $crumbPath = '\PHPMinion\Utilities\Dbug\Crumbs';
        $this->registerCrumb('dbug', $crumbPath.'\DbugDumpCrumb')
             ->registerCrumb('color', $crumbPath.'\DbugColorCrumb');

    }

    public function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Dbug();
        }

        return self::$_instance;
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

        $this->_tools[$alias] = $class;

        return $this;
    }

    /**
     * Registers a Crumb for rendering a DbugTool result
     *
     * TODO: allow crumb registration with arrays?
     *
     * @param string $toolAlias Previously declared DbugTool alias that will use the Crumb
     * @param string $class     Class to handle Dbug Tool output generation
     * @param bool   $replace   Allow replacing of a previously declared DbugTool Crumb?
     * @return Dbug
     * @throws DbugException
     */
    public function registerCrumb($toolAlias, $class, $replace = false)
    {
        $this->validateRegisterArgs($toolAlias, $class, 'crumb');

        if (isset($this->_crumbs[$toolAlias]) && !$replace) {
            throw new DbugException("ERROR: A Tool Crumb has already been registered for a Dbug Tool with alias '{$toolAlias}'.");
        }

        $this->_crumbs[$toolAlias] = $class;

        return $this;
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

        /*
        echo "calling __callStatic for method '{$name}'<BR>";
        echo "using args:<BR>";
        var_dump($args);
        echo "<BR><BR>";

        echo "debug obj:<BR>";
        var_dump($dbug);
        echo "<BR><BR><HR><BR><BR>";
        */

        $dbug->validateCalledTool($name);
        $tool = $dbug->getDbugTool($name);

        /*
        echo "tool:<BR>";
        var_dump($tool);
        echo "<HR>";
        die();
        */

        $tool->analyze($args);
        $dbug->_dbugStack[] = $tool->getDbugResults();

        return $dbug;
    }

    /**
     * Outputs all accumulated DbugTool results && die()
     *
     * @param string|bool $dieMsg
     */
    public function kill($dieMsg = false)
    {
        foreach ($this->_dbugStack as $dbug) {
            echo $dbug;
        }

        $dieMsg = (!$dieMsg) ? $this->_dieMsg : $dieMsg;

        die(Common::_colorize($dieMsg));
    }

    /**
     * Validates register args
     *
     * @param string $alias
     * @param string $class
     * @param string $which
     * @throws DbugException
     */
    private function validateRegisterArgs($alias, $class, $which = 'tool')
    {
        //list($ele, $bit) = ($which === 'tool') ? ['DbugTool', ''] : ['DbugToolCrumb', 'Crumb '];
        $ele = ($which === 'tool') ? 'DbugTool' : 'DbugToolCrumb';
        $invalidAliasErr = "Unable to register {$ele}: invalid alias '{$alias}'.";
        $invalidClassErr = "Unable to register {$ele}: invalid class '{$class}'.";

        if (!$this->validateAlias($alias)) {
            throw new DbugException($invalidAliasErr);
        }

        if (!$this->validateClass($class)) {
            throw new DbugException($invalidClassErr);
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
        if (!isset($this->_crumbs[$name])) {
            throw new DbugException("'{$name}' is not a registered DbugTool Crumb.");
        }
    }

    /**
     * Gets the requested DbugTool object
     *
     * @param  string $name
     * @return DbugTool
     */
    private function getDbugTool($name)
    {
        $crumb = new $this->_crumbs[$name];
        $crumb->toolAlias = $name;

        /** @var DbugTool $tool */
        $tool = new $this->_tools[$name]($name, $this);
        $tool->setCrumb($crumb);

        return $tool;
    }

}
