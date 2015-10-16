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

use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

/**
 * Class DbugColor
 *
 * Simple output of strings/numeric values in color for easy reading
 *
 * @created     October 16, 2015
 * @version     0.1
 */
class DbugColor extends DbugTool
{

    /**
     * Default color to use on dbug output
     *
     * @var string
     */
    protected $defaultColor = '#F00';

    /**
     * <code>
     * Method Args:
     *  mixed   $comment  Text to output in color (non-array/object)
     *  string  $color    Color to use on dbug output (default = '#F00')
     *  bool    $kill     Immediately terminate script (default = false)
     * </code>
     *
     * @inheritDoc
     */
    public function analyze(array $args)
    {
        $this->processArgs($args);

        /** @var \PHPMinion\Utilities\Dbug\Crumbs\DbugColorCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->getMethodInfoString($this->common->getMethodInfo());
        $crumb->dbugComment = $this->common->colorize($this->comment, $this->commentColor);

        $this->render();

        return $this;
    }

    /**
     * Processes arguments supplied to DbugDump
     *
     * @param array $args
     * @throws DbugException
     */
    private function processArgs(array $args)
    {
        if (empty($args[0])) {
            throw new DbugException("ERROR: No variable provided to DbugColor");
        }

        $this->comment = trim($args[0]);
        $this->commentColor = (!empty($args[1])) ? $args[1] : $this->defaultColor;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

    /**
     * Renders analysis results
     *
     * @return string
     */
    private function render()
    {
        $this->dbugResults = $this->crumb->render();
        $this->checkKillScript();

        return $this->dbugResults;
    }

    /**
     * Kills the script if kill flag set in analyze()
     */
    private function checkKillScript()
    {
        if (!$this->kill) {
            return;
        }

        echo $this->dbugResults;
        die($this->common->colorize($this->dieMessage));
    }

}