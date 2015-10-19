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
use PHPMinion\Utilities\Dbug\Crumbs\DbugDumpCrumb;
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;
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
class DbugDump extends DbugTool implements DbugToolInterface
{

    /**
     * @inheritDoc
     */
    public function __construct($toolAlias)
    {
        parent::__construct($toolAlias);
        $this->crumb = new DbugDumpCrumb($toolAlias);
    }

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

        $objectAnalyzer = Dbug::getInstance()->getConfig()->getObjectAnalyzer();

        /** @var \PHPMinion\Utilities\Dbug\Crumbs\DbugDumpCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->common->getMethodInfoString($this->common->getMethodInfo());
        $crumb->variableType = $this->common->getSimpleTypeValue($this->dbugTarget);
        $crumb->variableData = $this->common->getFullSimpleTypeValue($this->dbugTarget);
        $crumb->dbugComment = (empty($this->comment)) ? ''
                               : $this->common->colorize($this->comment, $this->commentColor).PHP_EOL.PHP_EOL;

        $this->checkKillScript();

        return $this;
    }

    /**
     * @inheritDoc
     * @throws DbugException
     */
    public function render()
    {
        if (!$this->crumb instanceof DbugCrumbInterface) {
            throw new DbugException("Unable to render tool '{$this->toolAlias}': '" . get_class($this->crumb) . "' must be an instance of DbugCrumbInterface.");
        }

        $this->crumb->config = $this->config;
        $this->dbugResults = $this->crumb->render();

        return $this->dbugResults;
    }

    /**
     * Processes arguments supplied to DbugDump
     *
     * @param array $args
     * @throws DbugException
     */
    protected function processArgs(array $args)
    {
        if (!isset($args[0])) {
            throw new DbugException("ERROR: No variable provided to DbugDump");
        }

        $this->dbugTarget = $args[0];
        $this->comment = (!empty($args[1])) ? $args[1] : null;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

}