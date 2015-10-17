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
 * DbugCrumb
 *
 * Base Crumb class
 *
 * @created     October 15, 2015
 * @version     0.1
 */
abstract class DbugCrumb
{

    /**
     * Alias used for DbugTool
     *
     * @var string
     */
    public $toolAlias;

    /**
     * CSS used in render()
     *
     * @var array
     */
    public $cssStyles = [
        'container'  => 'position: relative; font-family: monospace; font-size: 1em; background-color: #FFF; text-align: left; padding-bottom: 0px; margin: 10px; border-radius: 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'toolAlias'  => 'position: relative; font-size: 1.2em; border: 1px solid black; border-bottom-style: hidden; border-radius: 5px 5px 0 0; padding: 2px 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'pre'        => 'position: relative; display: block; margin-top: 0px; border-radius: 5px; border: 1px dashed black;',
        'dbugDiv'    => 'position: relative; margin: 10px;',
        'varDataDiv' => 'position: relative; padding: 5px 10px; border: 1px solid black; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
    ];

}