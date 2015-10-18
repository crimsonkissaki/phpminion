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
use PHPMinion\Utilities\Dbug\Crumbs\DbugTypeCrumb;
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;

class DbugType extends DbugTool implements DbugToolInterface
{

    /**
     * @inheritDoc
     */
    public function __construct($toolAlias)
    {
        parent::__construct($toolAlias);
        $this->crumb = new DbugTypeCrumb($toolAlias);
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

        /** @var DbugTypeCrumb $crumb */
        $crumb = $this->crumb;
        $crumb->callingMethodInfo = $this->common->getMethodInfoString($this->common->getMethodInfo());
        $crumb->dbugComment = (!is_null($this->comment)) ? PHP_EOL.$this->common->colorize($this->comment).PHP_EOL : '';
        $crumb->variableData = $this->common->getSimpleTypeValue($this->dbugTarget);

        $this->checkKillScript();

        return $this;
    }

    /**
     * Generates Dbug results
     *
     * @return string
     * @throws DbugException
     */
    public function render()
    {
        if (!$this->crumb instanceof DbugCrumbInterface) {
            throw new DbugException("Unable to render tool '{$this->toolAlias}': '" . get_class($this->crumb) . "' must be an instance of DbugCrumbInterface.");
        }

        $this->dbugResults = $this->crumb->render();

        return $this->dbugResults;
    }

    /**
     * Processes arguments supplied to DbugTrace
     *
     * @param array $args
     * @throws DbugException
     */
    protected function processArgs(array $args)
    {
        if (empty($args[0])) {
            throw new DbugException("Unable to execute '{$this->toolAlias}': no variable provided.");
        }
        $this->dbugTarget = $args[0];
        $this->comment = (!empty($args[1])) ? $args[1] : null;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

}