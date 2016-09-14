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
     * Analyzes a variable
     *
     * @param  array  $args  Args to be passed to DbugTool
     * @return DbugToolInterface
     */
    public function analyze(array $args);

    /**
     * Returns the Crumb renderer object
     *
     * @return DbugCrumbInterface
     */
    public function getCrumb();


    /**
     * Kills the script
    public function kill();
     */

}