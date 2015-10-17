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
     * Variable to debug
     *
     * @var mixed
     */
    protected $dbugTarget;

    /**
     * Dbug comments
     *
     * @var string
     */
    protected $comment;

    /**
     * Color to set DbugDump comment text
     *
     * @var string
     */
    protected $commentColor = '#F00';

    /**
     * Debugging output from DbugDumpCrumb
     *
     * @var string
     */
    protected $dbugResults;

    /**
     * Kill the script or not?
     *
     * If true script dumps output && die()
     *
     * @var bool
     */
    protected $kill = false;

    /**
     * Default message to display if die()
     *
     * Override in child DbugTool if desired
     *
     * @var string
     */
    protected $dieMessage = "<br>Killed by PHPMinion::Dbug<br>";

    public function getDbugResults()
    {
        return $this->dbugResults;
    }

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
        $this->dieMessage = "<br>Killed by Dbug::{$toolAlias}<br>";
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
     * Gets a string with data for the method where the DbugTool was called
     *
     * @param  TraceModel $trace
     * @return string
     */
    protected function getMethodInfoString(TraceModel $trace)
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
     * Renders analysis results
     *
     * @return string
     * @throws DbugException
     */
    protected function render()
    {
        if (!$this->crumb instanceof DbugCrumbInterface ) {
            throw new DbugException("Unable to render {$this->toolAlias}: Crumb must be an instance of DbugCrumbInterface.");
        }

        $this->dbugResults = $this->crumb->render();
        $this->checkKillScript();

        return $this->dbugResults;
    }

    /**
     * Kills the script if kill flag set in analyze()
     *
     * @throws DbugException
     */
    protected function checkKillScript()
    {
        if (!$this->kill) {
            return;
        }

        if (is_null($this->dbugResults)) {
            throw new DbugException("Unable to render {$this->toolAlias}: dbugResults is null.");
        }

        echo $this->dbugResults;
        $dieOutput = '<div style="position: relative;">'.$this->common->colorize($this->dieMessage).'</div>';
        die($dieOutput);
    }

}