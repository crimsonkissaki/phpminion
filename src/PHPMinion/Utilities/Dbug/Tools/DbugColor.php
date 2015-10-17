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
        $crumb->variableData = $this->common->colorize($this->dbugResults, $this->commentColor);

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
    private function convertTargetToUsableValue($target)
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