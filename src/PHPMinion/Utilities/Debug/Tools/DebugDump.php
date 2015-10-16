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

namespace PHPMinion\Utilities\Debug\Tools;

use PHPMinion\Utilities\Debug\Exceptions\DebugException;

class DebugDump extends DebugTool implements DebugToolInterface
{

    /**
     * Message to display if die()
     *
     * @var string
     */
    protected $dieMessage = "<br>Killed by DebugDump<br>";

    /**
     * Variable to debug
     *
     * @var mixed
     */
    protected $target;

    /**
     * Debug comments
     *
     * @var string
     */
    protected $comment;

    /**
     * Kill the script or not?
     *
     * @var bool
     */
    protected $kill = false;

    /**
     * Color to set DebugDump comment text
     *
     * @var string
     */
    protected $commentColor = '#F00';

    /**
     * @inheritDoc
     */
    public function analyze(array $args)
    {
        $this->processArgs($args);

        /** @var \PHPMinion\Utilities\Debug\Crumbs\DebugDumpCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->getMethodInfoString($this->common->getMethodInfo());
        $crumb->variableType = gettype($this->target);
        $crumb->variableData = $this->getSimpleTypeValue($this->target);
        $crumb->debugComment = (empty($this->comment)) ? ''
                               : $this->common->colorize($this->comment, $this->commentColor)."\n\n";

        $this->render();

        return $this;
    }

    /**
     * Kills the script
     */
    public function kill()
    {
        if (empty($this->debugResults)) {
            $this->render();
        }

        $msg = $this->common->colorize($this->dieMessage);

        if (!is_null($this->debug)) {
            $this->debug->kill($msg);
        }

        echo $this->debugResults;
        die($msg);
    }

    /**
     * Renders analysis results
     *
     * @return string
     */
    private function render()
    {
        $this->debugResults = $this->crumb->render();

        if ($this->kill) {
            $this->kill();
        }

        return $this->debugResults;
    }

    /**
     * Processes arguments supplied to DebugDump
     *
     * @param array $args
     */
    private function processArgs(array $args)
    {
        if (empty($args[0])) {
            throw new DebugException("ERROR: No variable provided to DebugDump");
        }

        $this->target = $args[0];
        $this->comment = (!empty($args[1])) ? $args[1] : null;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

}