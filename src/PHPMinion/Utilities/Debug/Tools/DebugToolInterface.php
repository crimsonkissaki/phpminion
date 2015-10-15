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

/**
 * Interface DebugToolInterface
 *
 * @package PHPMinion\Utilities\Debug
 */
interface DebugToolInterface
{

    /**
     * Analyzes a variable
     *
     * @param  array  $args  Args to be passed to DebugTool
     * @return mixed
     */
    public function analyze(array $args);

    /**
     * Renders analysis results
     *
     * @return mixed
     */
    public function render();

}