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
        'container'  => 'text-align: left; margin: 10px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'toolAlias'  => 'background-color: #FFF; border: 1px solid black; border-bottom-style: hidden; border-radius: 5px 5px 0 0; padding: 2px 5px; width: -webkit-fit-content; width: -moz-fit-content; width: fit-content;',
        'pre'        => 'background-color: #FFF; border: 1px dashed black;',
        'dbugDiv'    => 'margin: 5px 10px;',
        'varDataDiv' => 'padding: 5px 10px; border: 1px solid black;',
    ];

}