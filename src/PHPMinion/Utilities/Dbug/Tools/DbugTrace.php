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
use PHPMinion\Utilities\Dbug\Crumbs\DbugTraceCrumb;
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;
use PHPMinion\Utilities\Core\Common;

/**
 * Class DbugTrace
 *
 * Outputs a quick trace showing which classes/functions
 * were called, and on which line numbers, to get to
 * the current location.
 *
 * @created     October 16, 2015
 * @version     0.1
 */
class DbugTrace extends DbugTool implements DbugToolInterface
{

    /**
     * Default number of debug_backtrace() levels to parse
     *
     * @var int
     */
    protected $defaultLevels = 2;

    /**
     * Number of debug_backtrace() levels to parse
     *
     * @var int
     */
    protected $levels;

    public function getDbugResults()
    {
        return $this->dbugResults;
    }

    /**
     * @inheritDoc
     */
    public function __construct($toolAlias)
    {
        parent::__construct($toolAlias);
        $this->crumb = new DbugTraceCrumb($toolAlias);
    }

    /**
     * <code>
     * Method Args:
     *  string  $comment  Comments to display in debug output (default null)
     *  int     $index    Starting debug_backtrace() index (default 2)
     *  bool    $kill     Immediately terminate script (default false)
     * </code>
     *
     * @inheritDoc
     */
    public function analyze(array $args)
    {
        $this->processArgs($args);

        /** @var DbugTraceCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->common->getMethodInfoString($this->common->getMethodInfo());
        $crumb->dbugComment = (!is_null($this->comment)) ? $this->common->colorize($this->comment) . "\n\n" : '';
        $crumb->variableData = $this->parseStackTrace();

        $this->render();

        return $this;
    }

    /**
     * Processes arguments supplied to DbugTrace
     *
     * @param array $args
     */
    protected function processArgs(array $args)
    {
        $this->comment = (!empty($args[0])) ? $args[0] : null;
        $this->levels = (!empty($args[1])) ? $args[1] : $this->defaultLevels;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

    /**
     * Parses the stacktrace
     *
     * @return string
     */
    protected function parseStackTrace()
    {
        $trace = debug_backtrace();
        $traceStr = '';
        for ($i = 0; $i <= $this->levels; $i += 1 ) {
            $nextIndex = Common::DEFAULT_STARTING_BACKTRACE_INDEX + $this->levels - $i;
            $model = $this->common->getMethodInfo($nextIndex, $trace);
            $traceStr .= $this->common->getMethodInfoString($model) . PHP_EOL;
        }

        return $traceStr;
    }

    /**
     * Generates Dbug results
     *
     * @return string
     * @throws DbugException
     */
    protected function render()
    {
        if (!$this->crumb instanceof DbugCrumbInterface) {
            throw new DbugException("Unable to render tool '{$this->toolAlias}': '" . get_class($this->crumb) . "' must be an instance of DbugCrumbInterface.");
        }

        $this->dbugResults = $this->crumb->render();
        $this->checkKillScript();

        return $this->dbugResults;
    }

}
