<?php

namespace PHPMinion\Utilities\Debug\Crumbs;

/**
 * DebugCrumbInterface
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 15, 2015
 * @version     0.1
 */
interface DebugCrumbInterface
{

    /**
     * Renders results of DebugTool processing
     *
     * @return string
     */
    public function render();

}