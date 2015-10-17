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
class DbugTrace extends DbugTool
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

        /** @var \PHPMinion\Utilities\Dbug\Crumbs\DbugTraceCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->getMethodInfoString($this->common->getMethodInfo());
        $crumb->dbugComment = (!is_null($this->comment)) ? $this->common->colorize($this->comment) . "\n\n" : '';
        $crumb->variableData = $this->parseStackTrace();

        $this->render();

        return $this;
    }

    /**
     * Processes arguments supplied to DbugTrace
     *
     * @param array $args
     * @throws DbugException
     */
    private function processArgs(array $args)
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
    private function parseStackTrace()
    {
        $trace = debug_backtrace();
        $traceStr = '';
        for ($i = 0; $i <= $this->levels; $i += 1 ) {
            $nextIndex = Common::DEFAULT_STARTING_BACKTRACE_INDEX + $this->levels - $i;
            $model = $this->common->getMethodInfo($nextIndex, $trace);
            $traceStr .= $this->getMethodInfoString($model) . PHP_EOL;
        }

        return $traceStr;
    }

}
