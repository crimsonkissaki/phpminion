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
use PHPMinion\Utilities\Dbug\Crumbs\DbugColorCrumb;
use PHPMinion\Utilities\Dbug\Crumbs\DbugCrumbInterface;

/**
 * Class DbugColor
 *
 * Simple output of strings/numeric values in color for easy reading
 *
 * @created     October 16, 2015
 * @version     0.1
 */
class DbugColor extends DbugTool implements DbugToolInterface
{

    /**
     * Default color to use on dbug output
     *
     * @var string
     */
    protected $defaultColor = '#F00';

    /**
     * @inheritDoc
     */
    public function __construct($toolAlias)
    {
        parent::__construct($toolAlias);
        $this->crumb = new DbugColorCrumb($toolAlias);
    }

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
        $crumb->callingMethodInfo = $this->common->getMethodInfoString($this->common->getMethodInfo());
        $crumb->variableData = $this->common->colorize($this->dbugResults, $this->commentColor);

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
        if (empty($args[0])) {
            throw new DbugException("ERROR: No variable provided to DbugColor");
        }

        $this->dbugTarget = $args[0];
        $this->dbugResults = $this->convertTargetToUsableValue($this->dbugTarget);
        $this->commentColor = (!empty($args[1])) ? $args[1] : $this->defaultColor;
        $this->kill = (!empty($args[2])) ? $args[2] : false;
    }

    /**
     * Converts the var to a format usable by DbugColor
     *
     * @param $target
     * @return string
     */
    protected function convertTargetToUsableValue($target)
    {
        if (is_object($target)) {
            ob_start();
            var_dump($target);
            return ob_get_clean();
        }
        if (is_array($target)) {
            ob_start();
            print_r($target);
            return ob_get_clean();
        }

        return $target;
    }

}