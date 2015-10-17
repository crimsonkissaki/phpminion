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

use PHPMinion\Utilities\Dbug\Dbug;
use PHPMinion\Utilities\Dbug\Exceptions\DbugException;

/**
 * Class DbugDump
 *
 * More robust var_dump() & print_r() alternative that *should* be
 * able to prevent out of memory errors caused by large objects/arrays.
 *
 * @created     October 16, 2015
 * @version     0.1
 */
class DbugDump extends DbugTool
{

    /**
     * <code>
     * Method Args:
     *  mixed   $target   Variable to target
     *  string  $comment  Comments to display in debug output (default = '')
     *  bool    $kill     Immediately terminate script (default = false)
     * </code>
     *
     * @inheritDoc
     */
    public function analyze(array $args)
    {
        $this->processArgs($args);

        /** @var \PHPMinion\Utilities\Dbug\Crumbs\DbugDumpCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->getMethodInfoString($this->common->getMethodInfo());
        $crumb->variableType = $this->common->getSimpleTypeValue($this->dbugTarget);
        $crumb->variableData = $this->common->getFullSimpleTypeValue($this->dbugTarget);
        $crumb->dbugComment = (empty($this->comment)) ? ''
                               : $this->common->colorize($this->comment, $this->commentColor)."\n\n";

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
            throw new DbugException("ERROR: No variable provided to DbugDump");
        }

        $this->dbugTarget = $args[0];
        $this->comment = (!empty($args[1])) ? $args[1] : null;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

}