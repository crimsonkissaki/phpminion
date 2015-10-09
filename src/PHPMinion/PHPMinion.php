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

namespace PHPMinion;

/**
 * Primary entry point for suite tools
 *
 * Can be used as a simple facade gateway or bypassed entirely if you want to
 * directly instantiate the * utility classes.
 */
class PHPMinion
{

    /**
     * Container array for certain classes that can be created as Singletons
     *
     * @var array
     */
    private $_classes = [];

    /**
     * Gets an instance of a utility class
     *
     * @param   string $_class
     * @returns mixed
     */
    public function getInstance($_class)
    {
        die(__METHOD__);
    }

}

