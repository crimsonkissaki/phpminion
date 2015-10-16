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

namespace PHPMinion\Utilities\Dbug\Crumbs;

/**
 * DbugCrumbInterface
 *
 * @created     October 15, 2015
 * @version     0.1
 */
interface DbugCrumbInterface
{

    /**
     * Renders results of DbugTool processing
     *
     * @return string
     */
    public function render();

}