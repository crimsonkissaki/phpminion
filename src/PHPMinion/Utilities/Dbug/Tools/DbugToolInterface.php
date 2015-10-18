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

/**
 * Interface DbugToolInterface
 *
 * @created     October 9, 2015
 * @version     0.1
 */
interface DbugToolInterface
{

    /**
     * Gets the alias assigned to the DbugTool
     *
     * @return string
     */
    public function getToolAlias();

    /**
     * Sets DbugTool config options (if any)
     *
     * @param mixed
     */
    public function setConfig($config);

    /**
     * Analyzes a variable
     *
     * @param  array  $args  Args to be passed to DbugTool
     * @return DbugToolInterface
     */
    public function analyze(array $args);

    /**
     * Generates Dbug results
     *
     * @return string
     */
    public function render();

}