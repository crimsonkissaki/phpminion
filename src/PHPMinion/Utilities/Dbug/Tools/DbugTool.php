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
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumb;
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;
use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

/**
 * Class DbugTool
 *
 * Parent class for all DbugTools
 *
 * Provides basic properties applicable to most DbugTool use cases.
 *
 * Results from DbugTool analysis MUST be assigned to dbugResults
 * for proper handling.
 *
 * @created     October 15, 2015
 * @version     0.1
 */
abstract class DbugTool
{

    /**
     * Common utility class
     *
     * @var Common
     */
    protected $common;

    /**
     * DbugTool rendering Crumb object
     *
     * @var DbugCrumbInterface
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
     * Default color to set DbugDump comment text
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
     * Message to display on kill()
     *
     * @var string
     */
    protected $dieMessage = "<br>Killed by PHPMinion::DbugTool<br>";

    /**
     * Configuration settings
     *
     * @var array
     */
    protected $config = [];

    /**
     * @param DbugCrumbInterface $crumb
     */
    public function setCrumb(DbugCrumbInterface $crumb)
    {
        $this->crumb = $crumb;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getToolAlias()
    {
        return $this->toolAlias;
    }

    /**
     * @param string $toolAlias Alias name for DbugTool
     */
    public function __construct($toolAlias)
    {
        $this->toolAlias = $toolAlias;
        $this->crumb = new DbugCrumb($toolAlias);
        $this->dieMessage = "<br>Killed by Dbug::{$toolAlias}<br>";
        $this->common = new Common();
    }

    /**
     * Default implementation
     *
     * Used for error checking in Dbug
     *
     * @throws DbugException
     */
    public function render()
    {
        throw new DbugException("No render() method defined for " . get_class($this));
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

        $this->render();

        if (is_null($this->dbugResults)) {
            throw new DbugException("Unable to render {$this->toolAlias}: dbugResults is null.");
        }

        echo $this->dbugResults;
        $dieOutput = '<div style="position: relative;">' . $this->common->colorize($this->dieMessage) . '</div>';
        die($dieOutput);
    }

}